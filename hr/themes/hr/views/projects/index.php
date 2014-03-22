<?php
if (!isset($cs)) $cs = Yii::app()->getClientScript();
if (!isset($baseUrl)) $baseUrl = Yii::app()->theme->baseUrl;
$cs->registerCssFile($cs->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css');
//$cs->registerCssFile($baseUrl . '/js/bootstrap-datetimepicker-0.0.11/css/bootstrap-datetimepicker.min.css');
$cs->registerCoreScript('jquery.ui');
$cs->registerScript('$divisions_data', ViewHelper::objectToJsView(ViewHelper::divisions(), 'id', 'name', '$divisions'), CClientScript::POS_HEAD);
$cs->registerScript('$roles_data', ViewHelper::arrayToJsView(ViewHelper::roles(), '$roles'), CClientScript::POS_HEAD);
$cs->registerScript('$time_offset_data', 'var $time_offset = ' . ViewHelper::getTimeOffset() . ';', CClientScript::POS_HEAD);
//$cs->registerScriptFile($baseUrl . '/js/bootstrap-datetimepicker-0.0.11/js/bootstrap-datetimepicker.min.js');
$cs->registerScriptFile($baseUrl . '/js/plugins/jquery-ui-timepicker-addon.js');
$cs->registerScriptFile($baseUrl . '/js/date.format.js');
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

<h1><?php echo GxHtml::encode(Projects::label(2)); ?>
	<span class="label label-info">
		Fixed Bid</span>
	<span class="label label-success">
		Dedicated</span>
</h1>
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
			<div id="project_0" class="view" data-project-id="0">
				<h4>
					<!--<img src="">-->
					Free
				</h4>

				<div class="item-list">
					<?php foreach ($human_resources as $human_resource): ?>

						<div class="human-resource" data-resource="<?php echo GxHtml::encode(json_encode($human_resource)); ?>">
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


<div id="dialog-form" class="hide" title="Update working time">
	<p id="dialog_activity_tip"></p>

	<form class="form-inline dialog_form">
		<fieldset>
			<div id="dialog_current_project" class="row-fluid control-group">
				Current: <span id="dialog_current_project_name"></span>
			</div>

			<div class="row-fluid control-group">
				<div class="span6">
					<label class="control-label" for="dialog_division">
						Division:
					</label>
					<input type="text" id="dialog_division" class="input-small" disabled="disabled">
				</div>
				<div class="span6">
					<label class="control-label" for="dialog_role_id">Role: </label>
					<?php echo GxHtml::dropDownList('dialog_role_id', null, ViewHelper::roles(), array('class' => 'input-medium')); ?>
				</div>
			</div>

			<div class="row-fluid control-group">
				<label class="checkbox">
					<input type="checkbox" id="move_to" name="move_to" value="1">
					Move to:
				</label>
				<?php echo GxHtml::dropDownList('dialog_project_id', null, ViewHelper::projects(), array('style' => 'max-width:100%;width:auto;')); ?>
			</div>

			<div class="row-fluid control-group">
				<div class="span6">
					<label for="dialog_start_time">Start time:</label><br />

					<div class="input-append date-time-picker">
						<input class="input-medium" id="dialog_start_time" name="start_time" type="text">
						<label class="add-on" for="dialog_start_time">
							<i class="icon-calendar"></i>
						</label>
					</div>
				</div>

				<div class="span6">
					<label for="dialog_end_time">End time:</label><br />

					<div class="input-append date-time-picker">
						<input class="input-medium" id="dialog_end_time" name="end_time" type="text">
						<span id="end_time_remove" class="add-on">
							<i class="icon-remove"></i>
						</span>
						<label class="add-on" for="dialog_end_time">
							<i class="icon-calendar"></i>
						</label>
					</div>
				</div>
			</div>
		</fieldset>
	</form>
</div>

