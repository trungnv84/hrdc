<?php
if (!isset($cs)) $cs = Yii::app()->getClientScript();
if (!isset($baseUrl)) $baseUrl = Yii::app()->theme->baseUrl;
$cs->registerCssFile($cs->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css');
$cs->registerCoreScript('jquery.ui');
$cs->registerScriptFile($baseUrl . '/js/project_list.js');

$this->breadcrumbs = array(
	Projects::label(2),
	Yii::t('app', 'Index'),
);

$this->menu = array(
	array('label'=>Yii::t('app', 'Create') . ' ' . Projects::label(), 'url' => array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . Projects::label(2), 'url' => array('admin')),
);
?>

<h1><?php echo GxHtml::encode(Projects::label(2)); ?></h1>
<div id="projects_list">
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));?>
</div>