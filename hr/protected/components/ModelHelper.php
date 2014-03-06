<?php
class ModelHelper
{
	public static function dateTimeToIntForDB($date)
	{
		if (preg_match('/\d{1,2}-\d{1,2}-\d{4}/', $date)) {
			$dateObj = explode('-', $date);
			$dateObj = array_reverse($dateObj);
			$dateObj = new DateTime(implode('-', $dateObj));
		} elseif(is_int($date)) {
			$dateObj = new DateTime();
			$dateObj = $dateObj->setTimestamp($date);
		}

		if(isset($dateObj) && $dateObj) {
			$dateObj->setTimezone(new DateTimeZone(Yii::app()->params['dbTimeZone']));
			$dateObj = strtotime($dateObj->format('Y-m-d H:i:s'));
			return $dateObj;
		}

		return $date;
	}

	public static function dateTimeIntDBToFormat($format, $date)
	{
		$dateObj = new DateTime(date('Y-m-d H:i:s', $date), new DateTimeZone(Yii::app()->params['dbTimeZone']));
		$dateObj->setTimezone(new DateTimeZone(Yii::app()->timeZone));
		return $dateObj->format($format);
	}
}
