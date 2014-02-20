<?php

class DivisionsController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Divisions'),
		));
	}

	public function actionCreate() {
		$model = new Divisions;


		if (isset($_POST['Divisions'])) {
			$model->setAttributes($_POST['Divisions']);

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
		$model = $this->loadModel($id, 'Divisions');


		if (isset($_POST['Divisions'])) {
			$model->setAttributes($_POST['Divisions']);

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
			$this->loadModel($id, 'Divisions')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Divisions');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Divisions('search');
		$model->unsetAttributes();

		if (isset($_GET['Divisions']))
			$model->setAttributes($_GET['Divisions']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}