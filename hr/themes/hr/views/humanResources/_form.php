<?php
$cs = Yii::app()->getClientScript();
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerCssFile($baseUrl.'/js/select2-3.4.5/select2.css');
$cs->registerScriptFile($baseUrl.'/js/select2-3.4.5/select2.js');
$cs->registerScriptFile($baseUrl.'/js/human_resource_form.js');
?>
<div class="form">

	<?php $form = $this->beginWidget('GxActiveForm', array(
		'id' => 'human-resources-form',
		'enableAjaxValidation' => false,
	));
	?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?>
		<span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="span1">
			<?php echo $form->labelEx($model, 'employee_id', array('label' => 'ID')); ?>
			<?php echo $form->textField($model, 'employee_id', array('class' => 'span12', 'maxlength' => 10)); ?>
			<?php echo $form->error($model, 'employee_id'); ?>
		</div>
		<div class="span3">
			<?php echo $form->labelEx($model, 'name'); ?>
			<?php echo $form->textField($model, 'name', array('class' => 'span12', 'maxlength' => 60)); ?>
			<?php echo $form->error($model, 'name'); ?>
		</div>
		<div class="span2">
			<?php echo $form->labelEx($model, 'username', array('label' => 'User Account')); ?>
			<?php echo $form->textField($model, 'username', array('class' => 'span12', 'maxlength' => 60)); ?>
			<?php echo $form->error($model, 'username'); ?>
		</div>
		<div class="span2">
			<?php echo $form->labelEx($model, 'division_id'); ?>
			<?php echo $form->dropDownList($model, 'division_id', $divisions, array('empty' => '(Division)', 'class' => 'span12', 'maxlength' => 10)); ?>
			<?php echo $form->error($model, 'division_id'); ?>
		</div>
		<div class="span2">
			<?php echo $form->labelEx($model, 'phone'); ?>
			<?php echo $form->textField($model, 'phone', array('class' => 'span12')); ?>
			<?php echo $form->error($model, 'phone'); ?>
		</div>
	</div>
	<!-- row -->
	<div class="row">
		<div class="span3">
			<?php echo $form->labelEx($model, 'avatar'); ?>
			<?php echo $form->textField($model, 'avatar', array('class' => 'span12', 'maxlength' => 250)); ?>
			<?php echo $form->error($model, 'avatar'); ?>
		</div>
		<div class="span3">
			<?php echo $form->labelEx($model, 'email'); ?>
			<?php echo $form->textField($model, 'email', array('class' => 'span12', 'maxlength' => 250)); ?>
			<?php echo $form->error($model, 'email'); ?>
		</div>
		<div class="span3">
			<?php echo $form->labelEx($model, 'skype'); ?>
			<?php echo $form->textField($model, 'skype', array('class' => 'span12', 'maxlength' => 60)); ?>
			<?php echo $form->error($model, 'skype'); ?>
		</div>
		<div class="span2">
			<?php
			echo GxHtml::label('&nbsp;', null);
			echo GxHtml::htmlButton(Yii::t('app', 'Save'), array('type' => 'submit', 'class' => 'btn btn-primary'));
			?>
		</div>
	</div>
	<!--<div class="row">
		<?php /*echo $form->labelEx($model, 'position'); */?>
		<?php /*echo $form->textArea($model, 'position'); */?>
		<?php /*echo $form->error($model, 'position'); */?>
	</div>-->
	<!-- row -->


	<?php $this->endWidget();?>
</div><!-- form -->