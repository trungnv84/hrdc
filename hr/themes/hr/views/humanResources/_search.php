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
			<?php echo $form->dropDownList($model, 'division_id', CHtml::listData($divisions, 'id', 'name'), array('empty' => '(Select a division)', 'class' => 'span12', 'maxlength' => 10));?>
		</div>
		<div class="span2">
			<label>&nbsp;</label>
			<?php echo GxHtml::htmlButton(Yii::t('app', 'Search'), array('type' => 'submit', 'class' => 'btn')); ?>
		</div>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- search-form -->
