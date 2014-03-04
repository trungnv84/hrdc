<?php

class HumanResourcesController extends BaseController
{


	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id, 'HumanResources'),
		));
	}

	private function saveRedirect($id = null)
	{
		$redirect = Yii::app()->request->getPost('redirect');
		Yii::app()->user->setState("HumanResources_form_states_redirect", $redirect);
		switch ($redirect) {
			case 4:
				$this->redirect(array('view', 'id' => $id));
				break;
			case 3:
				$this->redirect(array('index'));
				break;
			case 2:
				$this->redirect(array('create'));
				break;
			case 1:
				$this->redirect(array('admin'));
				break;
			default:
				$this->redirect(array('update', 'id' => $id));
		}
	}

	public function actionCreate()
	{
		$model = new HumanResources;


		if (isset($_POST['HumanResources'])) {
			$model->setAttributes($_POST['HumanResources']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else {
					$this->saveRedirect($model->id);
				}
			}
		}

		$this->render('create', array(
			'model' => $model,
			'divisions' => Divisions::model()->findAll()
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id, 'HumanResources');


		if (isset($_POST['HumanResources'])) {
			$model->setAttributes($_POST['HumanResources']);

			if ($model->save()) {
				$this->saveRedirect($model->id);
			}
		}

		$this->render('update', array(
			'model' => $model,
			'divisions' => Divisions::model()->findAll()
		));
	}

	public function actionDelete($id)
	{
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'HumanResources')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('HumanResources');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model = new HumanResources('search');
		$model->unsetAttributes();

		$search = trim(Yii::app()->request->getQuery('search'));
		if ($search)
			$model->search = $search;

		if (isset($_GET['HumanResources']))
			$model->setAttributes($_GET['HumanResources']);

		$this->render('admin', array(
			'model' => $model,
			'divisions' => Divisions::model()->findAll()
		));
	}

	public function actionUsersSelection()
	{
		$criteria = new CDbCriteria;
		$criteria->select = 'id, username';
		$criteria->limit = 10;
		$q = trim(Yii::app()->request->getQuery('q'));
		if ($q) {
			$criteria->condition = 'username LIKE ?';
			$criteria->params = array($q . '%');
		}
		$users = Users::model()->findAll($criteria);
		$this->renderJson(array('users' => $users));
	}

	public function actionUploadAvatar()
	{
		// Create target dir
		$path = Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'images' .
			DIRECTORY_SEPARATOR . 'human_resources' . DIRECTORY_SEPARATOR;
		if (!is_dir($path)) @mkdir($path, 0755, true);

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
			$this->renderJson('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
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
			$this->renderJson('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				$this->renderJson('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}

			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				$this->renderJson('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		} else {
			if (!$in = @fopen("php://input", "rb")) {
				$this->renderJson('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
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

		$this->renderJson('{"jsonrpc" : "2.0", "result" : "' . (isset($fileNameUnique) ? $fileNameUnique : $fileName) . '", "id" : "id"}');
	}
}