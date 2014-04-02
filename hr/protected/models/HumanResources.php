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

		$criteria->compare('id', $this->id);
		$criteria->compare('employee_id', $this->employee_id, false);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('user_id', $this->user_id, false);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('division_id', $this->division_id, false);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('skype', $this->skype, true);

		if ($this->search) {
			$criteria2 = new CDbCriteria;
			$criteria2->compare('id', $this->search, false);
			$criteria2->compare('employee_id', $this->search, false, 'OR');
			$criteria2->compare('name', $this->search, true, 'OR');
			$criteria2->compare('username', $this->search, true, 'OR');
			$criteria2->compare('phone', $this->search, true, 'OR');
			$criteria2->compare('email', $this->search, true, 'OR');
			$criteria2->compare('skype', $this->search, true, 'OR');
			$criteria->mergeWith($criteria2);
		}

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => 30,
			),
		));
	}
}