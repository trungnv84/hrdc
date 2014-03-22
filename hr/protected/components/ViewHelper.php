<?php
class ViewHelper
{
	static $divisions;
	static $workings_now;
	static $human_resources;

	public static function &divisions()
	{
		if (!isset(self::$divisions)) {
			self::$divisions = Divisions::model()->findAll(array('index' => 'id'));
		}
		return self::$divisions;
	}

	public static function division($id)
	{
		static $divisions;
		if (!isset($divisions)) {
			$divisions = array();
			$division = self::divisions();
			foreach ($division as &$v) {
				$divisions[$v->id] = $v->name;
			}
		}
		if (is_numeric($id) && isset($divisions) && isset($divisions[$id]))
			return $divisions[$id];
		else return null;
	}

	public static function roles()
	{
		return Yii::app()->params['roles'];
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
			$image = 'project-logo.png';
		}
		return "images/projects/$type/$image";
	}

	public static function projects()
	{
		static $projects;
		if (!isset($projects))
			$projects = Projects::model()->findAll(array('index' => 'id'));
		return $projects;
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
				'condition' => "status = 1 AND start_time <= $now AND (end_time = 0 OR end_time > $now)",
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
		static $working_times;
		if (!isset($working_times[$project_id])) {
			static $workings_now, $human_resources;
			if (!isset($workings_now)) $workings_now = & self::getWorkingsNow();
			if (!isset($human_resources)) $human_resources = & self::getHumanResources();
			$working_times[$project_id] = array();
			$referent_working_time_ids = array();
			foreach ($workings_now as &$value) {
				if ($value->project_id == $project_id) {
					$working_times[$project_id][$value->id] = (object)$value->getAttributes();
					$working_times[$project_id][$value->id]->resource = (object)$human_resources[$value->resource_id]->getAttributes();
					if ($value->left_point)
						$referent_working_time_ids[] = $value->left_point;
					if ($value->right_point)
						$referent_working_time_ids[] = $value->right_point;
				}
			}
			if ($referent_working_time_ids) {
				$referent_working_times = ModelHelper::getReferentWorkingTimes($referent_working_time_ids);
				foreach ($working_times[$project_id] as &$value) {
					if ($value->left_point && isset($referent_working_times[$value->left_point]))
						$value->left_point_start_time = $referent_working_times[$value->left_point]->start_time;
					if ($value->right_point && isset($referent_working_times[$value->right_point]))
						$value->right_point_end_time = $referent_working_times[$value->right_point]->end_time;
				}
			}
		}
		return $working_times[$project_id];
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

	public static function objectToJsView($data, $id, $value, $name)
	{
		$result = array();
		foreach ($data as &$v) {
			$result[] = $v->$id . ': "' . str_replace('"', '\\"', $v->$value) . '"';
		}
		return "var $name = {" . implode(',', $result) . '};';
	}

	public static function arrayToJsView($data, $name)
	{
		$result = array();
		foreach ($data as $k => &$v) {
			$result[] = $k . ': "' . str_replace('"', '\\"', $v) . '"';
		}
		return "var $name = {" . implode(',', $result) . '};';
	}

	public static function getTimeOffset()
	{
		$tz = new DateTime(null, new DateTimeZone(Yii::app()->timeZone));
		$db_tz = new DateTime(null, new DateTimeZone(Yii::app()->params['dbTimeZone']));
		return $tz->format('P') - $db_tz->format('P');
	}
}
