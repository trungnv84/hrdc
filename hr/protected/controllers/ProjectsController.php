<?php

class ProjectsController extends BaseController
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

		$now_db_time = ModelHelper::dateTimeToIntForDB(time());

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
			if ($new_start_time) {
				$new_start_time = ModelHelper::dateTimeToIntForDB($new_start_time);
				$working_time->setAttribute('start_time', $new_start_time);
			}
			if ($new_end_time)
				$working_time->setAttribute('end_time', $new_end_time > 0 ? ModelHelper::dateTimeToIntForDB($new_end_time) : 0);

			if ($working_time->save()) {
				/*if (false && $new_end_time > 0) { //TODO: Tạm thời bỏ qua trường hợp này, sẽ fix sau
					$next_start_time = ModelHelper::dateTimeToIntForDB($new_end_time);
					if ($next_start_time) {
						$working_time_future = WorkingTimes::model()->findAll(array(
							'condition' => "status = 1 AND resource_id = $working_time->resource_id AND start_time > $next_start_time",
							'order' => 'start_time'
						));
					}
					if ($working_time_future) {
						foreach ($working_time_future as $key => &$wt) {
							if ($wt->end_time) {
								if ($wt->end_time > $next_start_time) {
									$wt->setAttribute('start_time', $next_start_time);
									$wt->save();
									break;
								} else {
									$wt->setAttribute('status', 0);
									$wt->save();
									if (isset($working_time_future[$key + 1])) {
										$working_time_future[$key + 1]->lelt_point = $working_time->id;
									}
								}
							} else {
								$wt->setAttribute('start_time', $next_start_time);
								$wt->save();
								break;
							}
						}
					}
				} else */{
					if ($working_time->left_point) {
						$left_point = WorkingTimes::model()->findByPk($working_time->left_point);
						if ($left_point) {
							$left_point->setAttribute('end_time', $working_time->start_time);
							$left_point->save();
						}
					}

					WorkingTimes::model()->updateAll(
						array('status' => 0),
						"status = 1 AND resource_id = $working_time->resource_id AND start_time > $working_time->start_time"
						. ($working_time->end_time ? ' AND start_time < ' . $working_time->end_time : '')
					);
				}
				$status = 1;
			} else {
				$errors = $working_time->getErrors();
				$status = 0;
			}
		} elseif ($new_project_id) {
			if ($new_start_time)
				$new_start_time = ModelHelper::dateTimeToIntForDB($new_start_time);
			else $new_start_time = $now_db_time;

			if ($new_end_time > 0) $new_end_time = ModelHelper::dateTimeToIntForDB($new_end_time);
			else $new_end_time = 0;

			$new_working_time = new WorkingTimes();

			$new_working_time->setAttributes(array(
				'resource_id' => $resource_id,
				'project_id' => $new_project_id,
				'role' => $new_role_id,
				'start_time' => $new_start_time,
				'end_time' => $new_end_time,
				'left_point' => ($working_time ? $working_time->id : 0),
				'right_point' => 0,
				'status' => 1
			));

			if ($new_working_time->save()) {
				if ($working_time) {
					$working_time->setAttributes(array(
						'end_time' => $new_start_time,
						'right_point' => $new_working_time->id
					));
					$working_time->save();
				}

				$working_time = $new_working_time;

				WorkingTimes::model()->updateAll(
					array('status' => 0),
					"status = 1 AND resource_id = $working_time->resource_id AND start_time > $working_time->start_time"
					. ($working_time->end_time ? ' AND start_time < ' . $working_time->end_time : '')
				);

				$status = 1;
			} else {
				$errors = $new_working_time->getErrors();
				$status = 0;
			}

			$status = 1;
		} elseif ($working_time) {
			$working_time->setAttribute('end_time', $now_db_time);
			if ($working_time->save()) {
				$working_time = false;
				$status = 1;
			} else {
				$errors = $working_time->getErrors();
				$status = 0;
			}
		} else {
			$status = 0;
		}

		$result = array(
			'status' => $status
		);

		if ($status) {
			if ($working_time) {
				if ($working_time->start_time > $now_db_time || $working_time->end_time < $now_db_time) {
					$working_time = WorkingTimes::model()->find(array(
						'condition' => "status = 1 AND resource_id = $resource_id AND start_time <= $now_db_time AND (end_time = 0 OR end_time > $now_db_time)",
					));
				}
				if ($working_time) {
					$result['working_time'] = (object)$working_time->getAttributes();
					$result['working_time']->resource = (object)$resource->getAttributes();
					$referent_working_time_ids = array();
					if ($result['working_time']->left_point)
						$referent_working_time_ids[] = $result['working_time']->left_point;
					if ($result['working_time']->right_point)
						$referent_working_time_ids[] = $result['working_time']->right_point;
					if ($referent_working_time_ids) {
						$referent_working_times = ModelHelper::getReferentWorkingTimes($referent_working_time_ids);
						if ($result['working_time']->left_point && isset($referent_working_times[$result['working_time']->left_point]))
							$result['working_time']->left_point_start_time = $referent_working_times[$result['working_time']->left_point]->start_time;
						if ($result['working_time']->right_point && isset($referent_working_times[$result['working_time']->right_point]))
							$result['working_time']->right_point_end_time = $referent_working_times[$result['working_time']->right_point]->end_time;
					}
				} else {
					$result['resource'] = (object)$resource->getAttributes();
				}
			} else {
				$result['resource'] = (object)$resource->getAttributes();
			}
		} elseif ($errors) {
			$result['message'] = "";
		}

		echo json_encode($result);
	}
}