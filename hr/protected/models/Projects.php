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

		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('short_name', $this->short_name, true);
		$criteria->compare('type', $this->type);

		if ($this->search) {
			if (isset($this->search['text']) && $this->search['text']) {
				$criteria->compare('id', $this->search['text'], false);
				$criteria->compare('name', $this->search['text'], true, 'OR');
				$criteria->compare('short_name', $this->search['text'], true, 'OR');
			}
		}

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function beforeValidate()
	{
		if (preg_match('/\d{1,2}-\d{1,2}-\d{4}/', $this->discovery_phase_starts)) {
			$date = explode('-', $this->discovery_phase_starts);
			$date = array_reverse($date);
			$this->discovery_phase_starts = strtotime($date);
		}
		return parent::beforeValidate();
	}
}