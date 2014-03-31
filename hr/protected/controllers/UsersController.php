<?php

class UsersController extends BaseController
{

	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions' => array('index', 'view'),
				'users' => array('@'),
			),
			array('allow',
				'actions' => array('minicreate', 'create', 'update'),
				'roles' => array(1),
			),
			array('allow',
				'actions' => array('admin', 'delete'),
				'roles' => array(1),
			),
			array('deny',
				'users' => array('*'),
			),
		);
	}

	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Users'),
		));
	}

	public function actionCreate()
	{
		$model = new Users;

		if (isset($_POST['Users'])) {
			$_POST['Users']['password'] = ModelHelper::password($_POST['Users']['password']);
			$model->setAttributes($_POST['Users']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->saveRedirect($model->id);
			}
		}

		$model->setAttribute('password', null);

		$this->render('create', array('model' => $model));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id, 'Users');

		if (isset($_POST['Users'])) {
			if (trim($_POST['Users']['password']))
				$_POST['Users']['password'] = ModelHelper::password($_POST['Users']['password']);
			else unset($_POST['Users']['password']);
			$model->setAttributes($_POST['Users']);

			if ($model->save()) {
				$this->saveRedirect($model->id);
			}
		}

		$model->setAttribute('password', null);

		$this->render('update', array(
			'model' => $model,
		));
	}

	public function actionDelete($id)
	{
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Users')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Users');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model = new Users('search');
		$model->unsetAttributes();

		$search = Yii::app()->request->getQuery('search');
		if ($search)
			$model->search = $search;

		if (isset($_GET['Users']))
			$model->setAttributes($_GET['Users']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}