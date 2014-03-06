<?php
class ControllerHelper
{
	public static function upload($path)
	{
		// Get a file name
		if (isset($_REQUEST["name"])) {
			$fileName = $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
			$fileName = $_FILES["file"]["name"];
		} else {
			$fileName = uniqid("file_");
		}

		// Chunking might be enabled
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

		$filePath = $path . $fileName;

		$pathInfo = pathinfo($fileName);
		$pathInfo['unique'] = 0;
		while (file_exists($filePath)) {
			$fileNameUnique = "$pathInfo[filename]-$pathInfo[unique].$pathInfo[extension]";
			$filePath = $path . $fileNameUnique;
			$pathInfo['unique']++;
		}

		if (!is_dir($path) || !$dir = opendir($path)) {
			return '{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}';
		}

		while (($file = readdir($dir)) !== false) {
			$tmpFilePath = $path . $file;

			// If temp file is current file proceed to the next
			if ($tmpFilePath == $filePath . '.part') {
				continue;
			}

			// Remove temp file if it is older than the max age and is not the current file
			if (preg_match('/\.part$/', $file) && (filemtime($tmpFilePath) < time() - 24 * 3600)) {
				@unlink($tmpFilePath);
			}
		}
		closedir($dir);

		// Open temp file
		if (!$out = @fopen($filePath . '.part', $chunks ? "ab" : "wb")) {
			return '{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}';
		}

		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				return '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}';
			}

			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				return '{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}';
			}
		} else {
			if (!$in = @fopen("php://input", "rb")) {
				return '{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}';
			}
		}

		while ($buff = fread($in, 4096)) {
			fwrite($out, $buff);
		}

		@fclose($out);
		@fclose($in);

		// Check if file has been uploaded
		if (!$chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off
			rename($filePath . '.part', $filePath);
		}

		return '{"jsonrpc" : "2.0", "result" : "' . (isset($fileNameUnique) ? $fileNameUnique : $fileName) . '", "id" : "id"}';
	}
}