<?php

Yii::import('application.models._base.BaseUsers');

class Users extends BaseUsers
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
		$criteria->compare('username', $this->username, true);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('roles', $this->roles);

		if ($this->search) {
			$criteria2 = new CDbCriteria;
			$criteria2->compare('username', $this->search, true);
			$criteria2->compare('email', $this->search, true, 'OR');
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