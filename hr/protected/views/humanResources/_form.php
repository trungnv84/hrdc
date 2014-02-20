<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'human-resources-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 60)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model, 'user_id', array('maxlength' => 60)); ?>
		<?php echo $form->error($model,'user_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'division_id'); ?>
		<?php echo $form->textField($model, 'division_id', array('maxlength' => 10)); ?>
		<?php echo $form->error($model,'division_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'avatar'); ?>
		<?php echo $form->textField($model, 'avatar', array('maxlength' => 250)); ?>
		<?php echo $form->error($model,'avatar'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textArea($model, 'phone'); ?>
		<?php echo $form->error($model,'phone'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model, 'email', array('maxlength' => 250)); ?>
		<?php echo $form->error($model,'email'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'skype'); ?>
		<?php echo $form->textField($model, 'skype', array('maxlength' => 60)); ?>
		<?php echo $form->error($model,'skype'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->textArea($model, 'position'); ?>
		<?php echo $form->error($model,'position'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->