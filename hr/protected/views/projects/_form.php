<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'projects-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 120)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'short_name'); ?>
		<?php echo $form->textField($model, 'short_name', array('maxlength' => 30)); ?>
		<?php echo $form->error($model,'short_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->textField($model, 'image', array('maxlength' => 250)); ?>
		<?php echo $form->error($model,'image'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'logo'); ?>
		<?php echo $form->textField($model, 'logo', array('maxlength' => 250)); ?>
		<?php echo $form->error($model,'logo'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'icon'); ?>
		<?php echo $form->textField($model, 'icon', array('maxlength' => 250)); ?>
		<?php echo $form->error($model,'icon'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model, 'type'); ?>
		<?php echo $form->error($model,'type'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'billable_effort'); ?>
		<?php echo $form->textField($model, 'billable_effort', array('maxlength' => 10)); ?>
		<?php echo $form->error($model,'billable_effort'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'total_effort'); ?>
		<?php echo $form->textField($model, 'total_effort', array('maxlength' => 10)); ?>
		<?php echo $form->error($model,'total_effort'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'actual_effort'); ?>
		<?php echo $form->textField($model, 'actual_effort', array('maxlength' => 10)); ?>
		<?php echo $form->error($model,'actual_effort'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'discovery_phase_starts'); ?>
		<?php echo $form->textField($model, 'discovery_phase_starts', array('maxlength' => 10)); ?>
		<?php echo $form->error($model,'discovery_phase_starts'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'development_phase_starts'); ?>
		<?php echo $form->textField($model, 'development_phase_starts', array('maxlength' => 10)); ?>
		<?php echo $form->error($model,'development_phase_starts'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'end_development_phase_starts'); ?>
		<?php echo $form->textField($model, 'end_development_phase_starts'); ?>
		<?php echo $form->error($model,'end_development_phase_starts'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'uat_phase_starts'); ?>
		<?php echo $form->textField($model, 'uat_phase_starts'); ?>
		<?php echo $form->error($model,'uat_phase_starts'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'resources'); ?>
		<?php echo $form->textArea($model, 'resources'); ?>
		<?php echo $form->error($model,'resources'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->