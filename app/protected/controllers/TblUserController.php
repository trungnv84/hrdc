<?php

class TblUserController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'TblUser'),
		));
	}

	public function actionCreate() {
		$model = new TblUser;


		if (isset($_POST['TblUser'])) {
			$model->setAttributes($_POST['TblUser']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'TblUser');


		if (isset($_POST['TblUser'])) {
			$model->setAttributes($_POST['TblUser']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'TblUser')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('TblUser');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new TblUser('search');
		$model->unsetAttributes();

		if (isset($_GET['TblUser']))
			$model->setAttributes($_GET['TblUser']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}