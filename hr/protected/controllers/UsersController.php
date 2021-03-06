<?php

class UsersController extends BaseController
{
	public $layout = 'column1';
	private static $allowRoles = array('Admin', 'BOM', 'Chief');

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
				'roles' => ModelHelper::getRoleIdsByNames(self::$allowRoles),
			),
			array('allow',
				'actions' => array('admin', 'delete'),
				'roles' => ModelHelper::getRoleIdsByNames(self::$allowRoles),
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
			$user = $_POST['Users'];
			$user['password'] = ModelHelper::password($user['password']);
			$model->setAttributes($user);

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
			$user = $_POST['Users'];
			if (trim($user['password']))
				$user['password'] = ModelHelper::password($user['password']);
			else unset($user['password']);
			$model->setAttributes($user);

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