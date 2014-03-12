<?php

class ProjectsController extends BaseController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Projects'),
		));
	}

	public function actionCreate() {
		$model = new Projects;


		if (isset($_POST['Projects'])) {
			$model->setAttributes($_POST['Projects']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->saveRedirect($model->id);
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Projects');


		if (isset($_POST['Projects'])) {
			$model->setAttributes($_POST['Projects']);

			if ($model->save()) {
				$this->saveRedirect($model->id);
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Projects')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Projects', array(
			'pagination' => false
		));
		//$projects = $dataProvider->getData();

		$this->render('index', array(
			'dataProvider' => $dataProvider
		));
	}

	public function actionAdmin() {
		$model = new Projects('search');
		$model->unsetAttributes();

		$search = Yii::app()->request->getQuery('search');
		if ($search)
			$model->search = $search;

		if (isset($_GET['Projects']))
			$model->setAttributes($_GET['Projects']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionUploadImages(){
		$type = Yii::app()->request->getQuery('type', '');
		switch ($type) {
			default:
				$this->renderJson('{"jsonrpc" : "2.0", "result" : "", "id" : "id"}');
				break;
			case 'logos':
			case 'icons':
		}
		// Create target dir
		$path = Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'images' .
				DIRECTORY_SEPARATOR . 'projects' . DIRECTORY_SEPARATOR .  $type . DIRECTORY_SEPARATOR;
		if (!is_dir($path)) @mkdir($path, 0755, true);

		$this->renderJson(ControllerHelper::upload($path));
	}

	public function actionUpdateWorkingTime()
	{

	}
}