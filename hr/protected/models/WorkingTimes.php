<?php

Yii::import('application.models._base.BaseWorkingTimes');

class WorkingTimes extends BaseWorkingTimes
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}