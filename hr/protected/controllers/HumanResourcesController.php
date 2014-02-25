<?php

class HumanResourcesController extends BaseController
{


	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id, 'HumanResources'),
		));
	}

	public function actionCreate()
	{
		$model = new HumanResources;


		if (isset($_POST['HumanResources'])) {
			$model->setAttributes($_POST['HumanResources']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array(
			'model' => $model,
			'divisions' => Divisions::model()->findAll()
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id, 'HumanResources');


		if (isset($_POST['HumanResources'])) {
			$model->setAttributes($_POST['HumanResources']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
			'model' => $model,
			'divisions' => Divisions::model()->findAll()
		));
	}

	public function actionDelete($id)
	{
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'HumanResources')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('HumanResources');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model = new HumanResources('search');
		$model->unsetAttributes();

		$search = trim(Yii::app()->request->getQuery('search'));
		if ($search)
			$model->search = $search;
		//TODO: need modify

		if (isset($_GET['HumanResources']))
			$model->setAttributes($_GET['HumanResources']);

		$this->render('admin', array(
			'model' => $model,
			'divisions' => Divisions::model()->findAll()
		));
	}

	public function actionUsersSelection()
	{
		$criteria = new CDbCriteria;
		$criteria->select = 'id, username';
		$criteria->limit = 10;
		$q = trim(Yii::app()->request->getQuery('q'));
		if ($q) {
			$criteria->condition = 'username LIKE ?';
			$criteria->params = array($q . '%');
		}
		$users = Users::model()->findAll($criteria);
		$this->renderJson(array('users' => $users));
	}

	public function actionUploadAvatar()
	{

		$this->renderJson('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}
}