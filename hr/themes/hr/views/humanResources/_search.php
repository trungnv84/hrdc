<div class="wide form">

	<?php $form = $this->beginWidget('GxActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
	)); ?>

	<div class="row">
		<div class="span3">
			<?php echo GxHtml::label('Search', 'search'); ?>
			<?php echo GxHtml::textField('search', null, array('class' => 'span12', 'maxlength' => 60)); ?>
		</div>
		<div class="span3">
			<?php echo $form->label($model, 'division_id'); ?>
			<?php echo $form->dropDownList($model, 'division_id', $divisions, array('empty' => '(Select a division)', 'class' => 'span12', 'maxlength' => 10));?>
		</div>
		<div class="span2">
			<label>&nbsp;</label>
			<?php echo GxHtml::htmlButton(Yii::t('app', 'Search'), array('type' => 'submit', 'class' => 'btn')); ?>
		</div>
	</div>

	<!--<div class="row">
		<?php /*echo $form->label($model, 'id'); */?>
		<?php /*echo $form->textField($model, 'id', array('maxlength' => 10)); */?>
	</div>

	<div class="row">
		<?php /*echo $form->label($model, 'name'); */?>
		<?php /*echo $form->textField($model, 'name', array('maxlength' => 60)); */?>
	</div>

	<div class="row">
		<?php /*echo $form->label($model, 'user_id'); */?>
		<?php /*echo $form->textField($model, 'user_id', array('maxlength' => 60)); */?>
	</div>

	<div class="row">
		<?php /*echo $form->label($model, 'division_id'); */?>
		<?php /*echo $form->textField($model, 'division_id', array('maxlength' => 10)); */?>
	</div>

	<div class="row">
		<?php /*echo $form->label($model, 'avatar'); */?>
		<?php /*echo $form->textField($model, 'avatar', array('maxlength' => 250)); */?>
	</div>

	<div class="row">
		<?php /*echo $form->label($model, 'phone'); */?>
		<?php /*echo $form->textArea($model, 'phone'); */?>
	</div>

	<div class="row">
		<?php /*echo $form->label($model, 'email'); */?>
		<?php /*echo $form->textField($model, 'email', array('maxlength' => 250)); */?>
	</div>

	<div class="row">
		<?php /*echo $form->label($model, 'skype'); */?>
		<?php /*echo $form->textField($model, 'skype', array('maxlength' => 60)); */?>
	</div>

	<div class="row">
		<?php /*echo $form->label($model, 'position'); */?>
		<?php echo $form->textArea($model, 'position'); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>-->

	<?php $this->endWidget(); ?>

</div><!-- search-form -->
