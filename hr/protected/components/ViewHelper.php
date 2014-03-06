<?php
class ViewHelper
{
	public static function division($division)
	{
		static $divisions;
		if (is_numeric($division)) {
			if (isset($divisions) && isset($divisions[$division])) return $divisions[$division];
			else return null;
		} elseif (is_array($division)) $divisions = $division;
		return true;
	}

	public static function projectType($type)
	{
		static $projectTypes;
		if (!isset($projectTypes))
			$projectTypes = Yii::app()->params['projectTypes'];
		return isset($projectTypes[$type]) ? $projectTypes[$type] : '';
	}

	public static function projectIcon(&$project)
	{
		if($project->icon) {
			$type = 'icons';
			$image = $project->icon;
		} elseif($project->logo) {
			$type = 'logos';
			$image = $project->logo;
		} else {
			$type = 'defaults';
			$image = 'logo.ico';
		}
		return "images/projects/$type/$image";
	}

	public static function dateTimeIntDBToFormat($format, $date)
	{
		$dateObj = new DateTime(date('Y-m-d H:i:s', $date), new DateTimeZone(Yii::app()->params['dbTimeZone']));
		$dateObj->setTimezone(new DateTimeZone(Yii::app()->timeZone));
		return $dateObj->format($format);
	}
}
