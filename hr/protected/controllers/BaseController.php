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
}