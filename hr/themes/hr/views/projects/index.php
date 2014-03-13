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
	array('label' => Yii::t('app', 'Create') . ' ' . Projects::label(), 'url' => array('create')),
	array('label' => Yii::t('app', 'Manage') . ' ' . Projects::label(2), 'url' => array('admin')),
);
?>

<h1><?php echo GxHtml::encode(Projects::label(2)); ?></h1>
<div id="projects_list">
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider' => $dataProvider,
		'itemView' => '_view',
	));

	$human_resources = ViewHelper::getFreeMenNow();
	//var_dump($human_resources);die;
	?>

	<div class="list-view" id="frees">
		<div class="items">
			<div class="view" data-project-id="0">
				<h4>
					<!--<img src="">-->
					Free
				</h4>

				<div class="item-list">
					<?php foreach ($human_resources as $human_resource): ?>

						<div class="human-resource" data-resource="<?php echo htmlentities(json_encode($human_resource)); ?>">
							<?php echo $human_resource->username ? $human_resource->username : $human_resource->name . " ($human_resource->employee_id)"; ?>
							<div class="edit-button">
								<a class="wt-apply" href="javascript:;" title="Apply">
									<i class="icon icon-ok"></i></a>
								<a class="wt-cancel" href="javascript:;" title="Cancel">
									<i class="icon icon-remove"></i></a>
							</div>
							<div class="pull-right saving-busy" title="Saving..."><!--&nbsp;&nbsp;s--></div>
							<a class="pull-right work-time-edit" href="javascript:;" title="Modify">
								<i class="icon icon-edit"></i></a>
						</div>

					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="dialog-form" title="Update working time">
	<p class="validateTips">All form fields are required.</p>
	<form>
		<fieldset>
			<label for="name">Name</label>
			<input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all">
			<label for="email">Email</label>
			<input type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all">
		</fieldset>
	</form>
</div>

