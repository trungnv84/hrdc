<?php

/**
 * This is the model base class for the table "human_resources".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "HumanResources".
 *
 * Columns in table "human_resources" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $employee_id
 * @property string $name
 * @property integer $user_id
 * @property string $username
 * @property integer $division_id
 * @property string $avatar
 * @property string $phone
 * @property string $email
 * @property string $skype
 * @property string $position
 *
 */
abstract class BaseHumanResources extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'human_resources';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'HumanResources|HumanResources', $n);
	}

	public static function representingColumn() {
		return 'employee_id';
	}

	public function rules() {
		return array(
			array('user_id, division_id', 'numerical', 'integerOnly'=>true),
			array('employee_id', 'length', 'max'=>10),
			array('name, username, skype', 'length', 'max'=>60),
			array('avatar, email', 'length', 'max'=>250),
			array('phone, position', 'safe'),
			array('employee_id, name, user_id, username, division_id, avatar, phone, email, skype, position', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, employee_id, name, user_id, username, division_id, avatar, phone, email, skype, position', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'employee_id' => Yii::t('app', 'Employee'),
			'name' => Yii::t('app', 'Name'),
			'user_id' => Yii::t('app', 'User'),
			'username' => Yii::t('app', 'Username'),
			'division_id' => Yii::t('app', 'Division'),
			'avatar' => Yii::t('app', 'Avatar'),
			'phone' => Yii::t('app', 'Phone'),
			'email' => Yii::t('app', 'Email'),
			'skype' => Yii::t('app', 'Skype'),
			'position' => Yii::t('app', 'Position'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('employee_id', $this->employee_id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('division_id', $this->division_id);
		$criteria->compare('avatar', $this->avatar, true);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('skype', $this->skype, true);
		$criteria->compare('position', $this->position, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}