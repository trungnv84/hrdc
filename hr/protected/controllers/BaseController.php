<?php
class BaseController extends GxController
{
	protected function renderJson($data = null)
	{
		if (is_scalar($data)) echo $data;
		else echo CJSON::encode($data);
		foreach (Yii::app()->log->routes as $route) {
			if ($route instanceof CWebLogRoute) {
				$route->enabled = false; // disable any weblogroutes
			}
		}
		header('Content-type: application/json');
		//$this->layout=false;
		Yii::app()->end();
	}

	protected function saveRedirect($id = null)
	{
		$redirect = Yii::app()->request->getPost('redirect');
		Yii::app()->user->setState(substr(get_class($this), 0, -10) . '_form_states_redirect', $redirect);
		switch ($redirect) {
			case 4:
				$this->redirect(array('view', 'id' => $id));
				break;
			case 3:
				$this->redirect(array('index'));
				break;
			case 2:
				$this->redirect(array('create'));
				break;
			case 1:
				$this->redirect(array('admin'));
				break;
			default:
				$this->redirect(array('update', 'id' => $id));
		}
	}
}