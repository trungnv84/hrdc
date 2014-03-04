<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id', array('maxlength' => 10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 120)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'short_name'); ?>
		<?php echo $form->textField($model, 'short_name', array('maxlength' => 30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'image'); ?>
		<?php echo $form->textField($model, 'image', array('maxlength' => 250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'logo'); ?>
		<?php echo $form->textField($model, 'logo', array('maxlength' => 250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'icon'); ?>
		<?php echo $form->textField($model, 'icon', array('maxlength' => 250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'type'); ?>
		<?php echo $form->textField($model, 'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'billable_effort'); ?>
		<?php echo $form->textField($model, 'billable_effort', array('maxlength' => 10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'total_effort'); ?>
		<?php echo $form->textField($model, 'total_effort', array('maxlength' => 10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'actual_effort'); ?>
		<?php echo $form->textField($model, 'actual_effort', array('maxlength' => 10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'discovery_phase_starts'); ?>
		<?php echo $form->textField($model, 'discovery_phase_starts', array('maxlength' => 10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'development_phase_starts'); ?>
		<?php echo $form->textField($model, 'development_phase_starts', array('maxlength' => 10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'end_development_phase_starts'); ?>
		<?php echo $form->textField($model, 'end_development_phase_starts'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'uat_phase_starts'); ?>
		<?php echo $form->textField($model, 'uat_phase_starts'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'resources'); ?>
		<?php echo $form->textArea($model, 'resources'); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
