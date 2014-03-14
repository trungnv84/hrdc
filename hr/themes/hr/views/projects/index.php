<?php
if (!isset($cs)) $cs = Yii::app()->getClientScript();
if (!isset($baseUrl)) $baseUrl = Yii::app()->theme->baseUrl;
$cs->registerCssFile($cs->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css');
$cs->registerCssFile($baseUrl . '/js/bootstrap-datetimepicker-0.0.11/css/bootstrap-datetimepicker.min.css');
$cs->registerCoreScript('jquery.ui');
$cs->registerScript('$divisions_data', ViewHelper::objectToJsView(ViewHelper::divisions(), 'id', 'name', '$divisions'), CClientScript::POS_HEAD);
$cs->registerScript('$roles_data', ViewHelper::arrayToJsView(ViewHelper::roles(), '$roles'), CClientScript::POS_HEAD);
$cs->registerScript('$time_offset_data', 'var $time_offset = ' . ViewHelper::getTimeOffset() . ';', CClientScript::POS_HEAD);
$cs->registerScriptFile($baseUrl . '/js/bootstrap-datetimepicker-0.0.11/js/bootstrap-datetimepicker.min.js');
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
	<p id="form_activity_tip"></p>

	<form class="form-inline">
		<fieldset>
			<div id="form_current_project" class="row-fluid control-group">
				Current: <span id="form_current_project_name"></span>
			</div>

			<div class="row-fluid control-group">
				<div class="span6">
					<label class="control-label" for="form_division">
						Division:
					</label>
					<input type="text" id="form_division" class="input-small" disabled="disabled">
				</div>
				<div class="span6">
					<label class="control-label" for="role">Role: </label>
					<?php echo GxHtml::dropDownList('role', null, ViewHelper::roles(), array('class' => 'input-medium')); ?>
				</div>
			</div>

			<div id="form_current_project" class="row-fluid control-group">
				<label class="checkbox">
					<input type="checkbox" id="move_to" name="move_to" value="1">
					Move to:
				</label>
				<?php echo GxHtml::dropDownList('role', null, ViewHelper::projects(), array('style' => 'max-width:100%;width:auto;')); ?>
			</div>

			<div class="row-fluid control-group">
				<div class="span6">
					<label for="start_time">Start time:</label><br />
					<div class="input-append date date-time-picker">
						<input class="input-medium" data-format="dd/MM/yyyy hh:mm" id="start_time" name="start_time" type="text">
						<label class="add-on" for="start_time">
							<i class="icon-calendar" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
						</label>
					</div>
				</div>

				<div class="span6">
					<label for="end_time">End time:</label><br />
					<div class="input-append date date-time-picker">
						<input class="input-medium" data-format="dd/MM/yyyy hh:mm" id="end_time" name="end_time" type="text">
						<label class="add-on" for="end_time">
							<i class="icon-calendar" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
						</label>
					</div>
				</div>
			</div>
		</fieldset>
	</form>
</div>

