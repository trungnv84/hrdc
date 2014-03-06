<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
		array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('projects-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>

<p>
You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'projects-grid',
	'dataProvider' => $model->search(),
	//'filter' => $model,
	'columns' => array(
		/*'id',*/
		'name',
		'short_name',
		array(
			'name' => 'type',
			'value' => 'ViewHelper::projectType($data->type)'
		),
		array(
			'name' => 'discovery_phase_starts',
			'header' => 'Start Date',
			'value' => '$data->discovery_phase_starts?ViewHelper::dateTimeIntDBToFormat(\'d/m/Y\', $data->discovery_phase_starts):\'\''
		),
		/*'development_phase_starts',*/
		array(
			'name' => 'end_development_phase_starts',
			'header' => 'End Date',
			'value' => '$data->end_development_phase_starts?ViewHelper::dateTimeIntDBToFormat(\'d/m/Y\', $data->end_development_phase_starts):\'\''
		),
		array(
			'name' => 'total_effort',
			'header' => 'Effort (hrs)',
			'value' => '"$data->actual_effort/$data->total_effort"'
		),
		/*'actual_effort',*/
		/*
		'image',
		'logo',
		'icon',
		'billable_effort',
		'uat_phase_starts',
		'resources',
		*/
		array(
			'class' => 'CButtonColumn',
		),
	),
)); ?>