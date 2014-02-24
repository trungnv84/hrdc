<?php

Yii::import('application.models._base.BaseHumanResources');

class HumanResources extends BaseHumanResources
{
	public $search = null;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, false);
		$criteria->compare('employee_id', $this->employee_id, false);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('user_id', $this->user_id, false);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('division_id', $this->division_id, false);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('skype', $this->skype, true);

		if ($this->search) {
			$criteria->compare('id', $this->search, false);
			$criteria->compare('employee_id', $this->search, false, 'OR');
			$criteria->compare('name', $this->search, true, 'OR');
			$criteria->compare('username', $this->search, true, 'OR');
			$criteria->compare('email', $this->search, true, 'OR');
			$criteria->compare('email', $this->search, true, 'OR');
			$criteria->compare('skype', $this->search, true, 'OR');
		}

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}