<?php

Yii::import('application.models._base.BaseHumanResources');

class HumanResources extends BaseHumanResources
{
	private $search = null;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('user_id', $this->user_id, true);
		$criteria->compare('division_id', $this->division_id, true);
		$criteria->compare('avatar', $this->avatar, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('skype', $this->skype, true);
		$criteria->compare('position', $this->position, true);

		if ($this->search) {
			$criteria->compare('id', $this->search, true, 'OR');
			$criteria->compare('name', $this->search, true, 'OR');
			$criteria->compare('user_id', $this->search, true, 'OR');
			$criteria->compare('email', $this->search, true, 'OR');
			$criteria->compare('skype', $this->search, true, 'OR');
			$criteria->compare('position', $this->search, true, 'OR');
		}

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}