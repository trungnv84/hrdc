<?php

/**
 * This is the model base class for the table "working_times".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "WorkingTimes".
 *
 * Columns in table "working_times" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property integer $resource_id
 * @property integer $project_id
 * @property integer $role
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $left_point
 * @property integer $right_point
 * @property integer $status
 * @property string $note
 *
 */
abstract class BaseWorkingTimes extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'working_times';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'WorkingTimes|WorkingTimes', $n);
	}

	public static function representingColumn() {
		return 'note';
	}

	public function rules() {
		return array(
			array('resource_id, project_id, role, start_time, end_time, left_point, right_point, status', 'numerical', 'integerOnly'=>true),
			array('note', 'safe'),
			array('resource_id, project_id, role, start_time, end_time, left_point, right_point, status, note', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, resource_id, project_id, role, start_time, end_time, left_point, right_point, status, note', 'safe', 'on'=>'search'),
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
			'resource_id' => Yii::t('app', 'Resource'),
			'project_id' => Yii::t('app', 'Project'),
			'role' => Yii::t('app', 'Role'),
			'start_time' => Yii::t('app', 'Start Time'),
			'end_time' => Yii::t('app', 'End Time'),
			'left_point' => Yii::t('app', 'Left Point'),
			'right_point' => Yii::t('app', 'Right Point'),
			'status' => Yii::t('app', 'Status'),
			'note' => Yii::t('app', 'Note'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('resource_id', $this->resource_id);
		$criteria->compare('project_id', $this->project_id);
		$criteria->compare('role', $this->role);
		$criteria->compare('start_time', $this->start_time);
		$criteria->compare('end_time', $this->end_time);
		$criteria->compare('left_point', $this->left_point);
		$criteria->compare('right_point', $this->right_point);
		$criteria->compare('status', $this->status);
		$criteria->compare('note', $this->note, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}