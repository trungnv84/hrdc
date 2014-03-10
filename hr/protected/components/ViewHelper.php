<?php
class ViewHelper
{
	static $workings_now;
	static $human_resources;

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
		if ($project->icon) {
			$type = 'icons';
			$image = $project->icon;
		} elseif ($project->logo) {
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

	public static function &getWorkingsNow()
	{
		if (!isset(self::$workings_now)) {
			$now = ModelHelper::dateTimeToIntForDB(time());
			self::$workings_now = WorkingTimes::model()->findAll(array(
				'condition' => "start_time <= $now AND (end_time = 0 OR end_time > $now)",
				'index' => 'id'
			));
		}
		return self::$workings_now;
	}

	public static function &getHumanResources()
	{
		if (!isset(self::$human_resources))
			self::$human_resources = HumanResources::model()->findAll(array('index' => 'id'));
		return self::$human_resources;
	}

	public static function getWorkerInProject($project_id)
	{
		static $resources;
		if (!isset($resources[$project_id])) {
			static $workings_now, $human_resources;
			if (!isset($workings_now)) $workings_now = & self::getWorkingsNow();
			if (!isset($human_resources)) $human_resources = & self::getHumanResources();
			$resources[$project_id] = array();
			foreach ($workings_now as &$value) {
				if ($value->project_id == $project_id) {
					$resources[$project_id][$value->id] = (object)$value->getAttributes();
					$resources[$project_id][$value->id]->resource = (object)$human_resources[$value->resource_id]->getAttributes();
				}
			}
		}
		return $resources[$project_id];
	}

	public static function getFreeMenNow()
	{
		static $free_men_now;
		if (!isset($resources[$free_men_now])) {
			static $workings_now, $human_resources;
			if (!isset($workings_now)) $workings_now = & self::getWorkingsNow();
			if (!isset($human_resources)) $human_resources = & self::getHumanResources();
			$resource_ids = array();
			foreach ($workings_now as &$value) {
				$resource_ids[] = $value->resource_id;
			}
			$free_men_now = array();
			foreach ($human_resources as &$value) {
				if (!in_array($value->id, $resource_ids)) {
					$free_men_now[$value->id] = (object)$value->getAttributes();
				}
			}
		}
		return $free_men_now;
	}
}
