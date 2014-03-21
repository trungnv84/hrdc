<?php

class ProjectsController extends BaseController
{


	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Projects'),
		));
	}

	public function actionCreate()
	{
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

		$this->render('create', array('model' => $model));
	}

	public function actionUpdate($id)
	{
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

	public function actionDelete($id)
	{
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Projects')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Projects', array(
			'pagination' => false
		));
		//$projects = $dataProvider->getData();

		$this->render('index', array(
			'dataProvider' => $dataProvider
		));
	}

	public function actionAdmin()
	{
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

	public function actionUploadImages()
	{
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
			DIRECTORY_SEPARATOR . 'projects' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR;
		if (!is_dir($path)) @mkdir($path, 0755, true);

		$this->renderJson(ControllerHelper::upload($path));
	}

	public function actionUpdateWorkingTime()
	{
		$new_project_id = (int)Yii::app()->request->getPost('new_project_id', 0);
		$new_role_id = (int)Yii::app()->request->getPost('new_role_id', 0);
		$new_start_time = (int)Yii::app()->request->getPost('new_start_time', 0);
		$new_end_time = (int)Yii::app()->request->getPost('new_end_time', 0);
		$resource_id = (int)Yii::app()->request->getPost('resource_id', 0);
		$resource = Yii::app()->request->getPost('resource', 0);
		$working_time = Yii::app()->request->getPost('working_time', 0);

		if ($working_time) $working_time = @json_decode($working_time);

		if ($resource) $resource = @json_decode($resource);

		if ($working_time) {
			if (isset($working_time->id)) $working_time_id = $working_time->id;
			if (!$resource && isset($working_time->resource)) $resource = $working_time->resource;
		}

		if (isset($working_time_id) && $working_time_id)
			$working_time = WorkingTimes::model()->findByPk($working_time_id);

		if ($resource && isset($resource->id)) $resource_id = $resource->id;

		if ($resource_id)
			$resource = HumanResources::model()->findByPk($resource_id);

		if ($working_time && $new_project_id == @$working_time->project_id) {
			if ($new_role_id)
				$working_time->setAttribute('role_id', $new_role_id);
			if ($new_start_time)
				$working_time->setAttribute('start_time', $new_start_time);
			if ($new_end_time)
				$working_time->setAttribute('end_time', $new_end_time);

			if ($working_time->save()) {
				$status = 1;
			} else {
				$errors = $working_time->getErrors();
				$status = 0;
			}
		} elseif ($new_project_id) {
			$status = 1;
		}

		$result = array(
			'status' => $status
		);
		echo json_encode($result);
	}
}