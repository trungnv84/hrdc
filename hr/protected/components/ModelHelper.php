<?php
class ModelHelper
{
	public static function dateTimeToIntForDB($date)
	{
		if (preg_match('/\d{1,2}-\d{1,2}-\d{4}/', $date)) {
			$dateObj = explode('-', $date);
			$dateObj = array_reverse($dateObj);
			$dateObj = new DateTime(implode('-', $dateObj));
		} elseif (is_int($date)) {
			$dateObj = new DateTime();
			$dateObj = $dateObj->setTimestamp($date);
		}

		if (isset($dateObj) && $dateObj) {
			$dateObj->setTimezone(new DateTimeZone(Yii::app()->params['dbTimeZone']));
			$dateObj = strtotime($dateObj->format('Y-m-d H:i:s'));
			return $dateObj;
		}

		return $date;
	}

	public static function getAllReferentWorkingTimes()
	{
		static $working_times;
		if (!isset($working_times)) {
			$now = self::dateTimeToIntForDB(time());
			$working_times = Yii::app()->db->createCommand()->from(
				"(SELECT * FROM working_times
					WHERE status = 1 AND (right_point > 0 AND end_time > 0 AND end_time < $now) OR (left_point > 0 AND start_time > 0 AND start_time > $now)
					ORDER BY LEAST($now - end_time, start_time - $now)
				) AS working_times"
			)->group('resource_id, project_id, IF(right_point > 0, 2, 0) | IF(left_point > 0, 1, 0)')->queryAll();
			/*'
			SELECT * FROM
			(SELECT * FROM working_times
				WHERE (right_point > 0 AND end_time > 0 AND end_time < $now) OR (left_point > 0 AND start_time > 0 AND start_time > $now)
				ORDER BY LEAST($now - end_time, start_time - $now)
			) AS working_times GROUP BY resource_id, project_id, IF(right_point > 0, 2, 0) | IF(left_point > 0, 1, 0)
			';*/
		}
		return $working_times;
	}

	public static function getReferentWorkingTimes($referent_working_time_ids)
	{
		static $working_times;
		if (!isset($working_times)) {
			$working_times = self::getAllReferentWorkingTimes();
		}
		$wts = array();
		foreach ($working_times as $wt) {
			if (in_array($wt['id'], $referent_working_time_ids))
				$wts[$wt['id']] = (object)$wt;
		}
		return $wts;
	}

	public static function password($password)
	{
		$hash = new CSecurityManager;
		$key = $hash->generateRandomString(rand(32, 64));
		return $hash->computeHMAC($password, $key) . ":$key";
	}
}
