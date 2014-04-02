<?php

Yii::import('application.models._base.BaseProjects');

class Projects extends BaseProjects
{
	public $search = null;

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('short_name', $this->short_name, true);
		$criteria->compare('type', $this->type);

		if ($this->search) {
			if (isset($this->search['text']) && $this->search['text']) {
				$criteria2 = new CDbCriteria;
				$criteria2->compare('id', $this->search['text'], false);
				$criteria2->compare('name', $this->search['text'], true, 'OR');
				$criteria2->compare('short_name', $this->search['text'], true, 'OR');
				$criteria->mergeWith($criteria2);
			}
		}

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => 30,
			),
		));
	}

	public function beforeValidate()
	{
		$this->discovery_phase_starts = ModelHelper::dateTimeToIntForDB($this->discovery_phase_starts);
		$this->development_phase_starts = ModelHelper::dateTimeToIntForDB($this->development_phase_starts);
		$this->end_development_phase_starts = ModelHelper::dateTimeToIntForDB($this->end_development_phase_starts);
		$this->uat_phase_starts = ModelHelper::dateTimeToIntForDB($this->uat_phase_starts);
		return parent::beforeValidate();
	}
}