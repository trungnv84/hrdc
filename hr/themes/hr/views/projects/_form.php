<?php
if (!isset($cs)) $cs = Yii::app()->getClientScript();
if (!isset($baseUrl)) $baseUrl = Yii::app()->theme->baseUrl;
$cs->registerCssFile($cs->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css');
$cs->registerCoreScript('jquery.ui');
$cs->registerScriptFile($baseUrl . '/js/plupload-2.1.1/plupload.full.min.js');
$cs->registerScriptFile($baseUrl . '/js/hotkey.js');
$cs->registerScriptFile($baseUrl . '/js/project_form.js');
$redirect = Yii::app()->user->getState("Projects_form_states_redirect", 0);
$saveTexts = array('', _SAVE_END_CLOSE, _SAVE_END_NEW);
?>
<div class="form">

	<?php $form = $this->beginWidget('GxActiveForm', array(
		'id' => 'projects-form',
		'enableAjaxValidation' => false,
	));
	?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?>
		<span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="span4">
			<?php echo $form->labelEx($model, 'name'); ?>
			<?php echo $form->textField($model, 'name', array('class' => 'span12 hot-key', 'maxlength' => 120)); ?>
			<?php echo $form->error($model, 'name'); ?>
		</div>
		<div class="span2">
			<?php echo $form->labelEx($model, 'short_name'); ?>
			<?php echo $form->textField($model, 'short_name', array('class' => 'span12 hot-key', 'maxlength' => 30)); ?>
			<?php echo $form->error($model, 'short_name'); ?>
		</div>
		<div class="span2">
			<?php echo $form->labelEx($model, 'type'); ?>
			<?php echo $form->dropDownList($model, 'type', Yii::app()->params['projectTypes'], array('empty' => '(Select type)', 'class' => 'span12 hot-key', 'maxlength' => 10)); ?>
			<?php echo $form->error($model, 'type'); ?>
		</div>
		<!--<div class="span1">
			<?php /*echo $form->labelEx($model, 'image'); */?>
			<?php /*echo $form->textField($model, 'image', array('class' => 'span12 hot-key', 'maxlength' => 250)); */?>
			<?php /*echo $form->error($model, 'image'); */?>
		</div>-->
		<div id="logo_container" class="span2">
			<?php echo $form->labelEx($model, 'logo'); ?>
			<?php echo $form->textField($model, 'logo', array('class' => 'span12 hot-key', 'maxlength' => 250, 'readonly' => true)); ?>
			<?php echo $form->error($model, 'logo'); ?>
		</div>
		<div id="icon_container" class="span2">
			<?php echo $form->labelEx($model, 'icon'); ?>
			<?php echo $form->textField($model, 'icon', array('class' => 'span12 hot-key', 'maxlength' => 250, 'readonly' => true)); ?>
			<?php echo $form->error($model, 'icon'); ?>
		</div>
	</div>
	<!-- row -->
	<div class="row">
		<div class="span3">
			<?php echo $form->labelEx($model, 'discovery_phase_starts'); ?>
			<div class="input-append">
				<?php echo $form->textField($model, 'discovery_phase_starts', array('value' => $model->discovery_phase_starts ? ViewHelper::dateTimeIntDBToFormat('d-m-Y', $model->discovery_phase_starts) : '', 'class' => 'span10 hot-key', 'maxlength' => 10)); ?>
				<label for="Projects_discovery_phase_starts" class="add-on"><i class="icon-calendar"></i></label>
			</div>
			<?php echo $form->error($model, 'discovery_phase_starts'); ?>
		</div>
		<div class="span3">
			<?php echo $form->labelEx($model, 'development_phase_starts'); ?>
			<div class="input-append">
				<?php echo $form->textField($model, 'development_phase_starts', array('value' => $model->development_phase_starts ? ViewHelper::dateTimeIntDBToFormat('d-m-Y', $model->development_phase_starts) : '', 'class' => 'span10 hot-key', 'maxlength' => 10)); ?>
				<label for="Projects_development_phase_starts" class="add-on"><i class="icon-calendar"></i></label>
			</div>
			<?php echo $form->error($model, 'development_phase_starts'); ?>
		</div>
		<div class="span3">
			<?php echo $form->labelEx($model, 'end_development_phase_starts'); ?>
			<div class="input-append">
				<?php echo $form->textField($model, 'end_development_phase_starts', array('value' => $model->end_development_phase_starts ? ViewHelper::dateTimeIntDBToFormat('d-m-Y', $model->end_development_phase_starts) : '', 'class' => 'span10 hot-key', 'maxlength' => 10)); ?>
				<label for="Projects_end_development_phase_starts" class="add-on"><i class="icon-calendar"></i></label>
			</div>
			<?php echo $form->error($model, 'end_development_phase_starts'); ?>
		</div>
		<div class="span3">
			<?php echo $form->labelEx($model, 'uat_phase_starts'); ?>
			<div class="input-append">
				<?php echo $form->textField($model, 'uat_phase_starts', array('value' => $model->uat_phase_starts ? ViewHelper::dateTimeIntDBToFormat('d-m-Y', $model->uat_phase_starts) : '', 'class' => 'span10 hot-key', 'maxlength' => 10)); ?>
				<label for="Projects_uat_phase_starts" class="add-on"><i class="icon-calendar"></i></label>
			</div>
			<?php echo $form->error($model, 'uat_phase_starts'); ?>
		</div>
	</div>
	<!-- row -->
	<div class="row">
		<div class="span2">
			<?php echo $form->labelEx($model, 'billable_effort', array('label' => 'Billable Effort (hrs)')); ?>
			<?php echo $form->textField($model, 'billable_effort', array('class' => 'span12 hot-key', 'maxlength' => 10)); ?>
			<?php echo $form->error($model, 'billable_effort'); ?>
		</div>
		<div class="span2">
			<?php echo $form->labelEx($model, 'total_effort', array('label' => 'Total Effort (hrs)')); ?>
			<?php echo $form->textField($model, 'total_effort', array('class' => 'span12 hot-key', 'maxlength' => 10)); ?>
			<?php echo $form->error($model, 'total_effort'); ?>
		</div>
		<div class="span3">
			<?php echo GxHtml::label('&nbsp;', null); ?>
			<div id="btn-submit-group" class="btn-group">
				<?php
				echo GxHtml::htmlButton('Save' . @$saveTexts[$redirect], array('type' => 'submit', 'id' => 'btn-save',
						'class' => 'btn btn-primary hot-key', 'data-hot-key-code' => 's'));
				$this->endWidget();
				?>
				<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li>
						<a id="btn-save-close" href="javascript:;">Save & close</a>
					</li>
					<li>
						<a id="btn-save-new" href="javascript:;">Save & new</a>
					</li>
					<li>
						<a id="btn-save-edit" href="javascript:;">Save & edit</a>
					</li>
				</ul>
			</div>
			<?php echo GxHtml::link('Cancel', array('admin'), array('class' => 'btn'));?>
			<input type="hidden" id="redirect" name="redirect" value="<?php echo $redirect; ?>">
		</div>
	</div>
	<!-- row -->
	<div class="row" style="display: none">
		<div class="span2">
			<?php echo $form->labelEx($model, 'actual_effort', array('label' => 'Actual Effort (hrs)')); ?>
			<?php echo $form->textField($model, 'actual_effort', array('class' => 'span12 hot-key', 'maxlength' => 10)); ?>
			<?php echo $form->error($model, 'actual_effort'); ?>
		</div>
		<div class="span1">
			<?php echo $form->labelEx($model, 'resources'); ?>
			<?php echo $form->hiddenField($model, 'resources'); ?>
			<?php echo $form->error($model, 'resources'); ?>
		</div>
	</div>
</div><!-- form -->