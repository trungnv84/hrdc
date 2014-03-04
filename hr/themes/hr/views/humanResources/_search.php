<?php
if (!isset($cs)) $cs = Yii::app()->getClientScript();
if (!isset($baseUrl)) $baseUrl = Yii::app()->theme->baseUrl;
$cs->registerScriptFile($baseUrl.'/js/hotkey.js');
?>
<div class="wide form">

	<?php $form = $this->beginWidget('GxActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
	)); ?>

	<div class="row">
		<div class="span3">
			<?php echo GxHtml::label('Search', 'search'); ?>
			<?php echo GxHtml::textField('search', null, array('class' => 'span12 hot-key', 'maxlength' => 60)); ?>
		</div>
		<div class="span3">
			<?php echo $form->label($model, 'division_id'); ?>
			<?php echo $form->dropDownList($model, 'division_id', CHtml::listData($divisions, 'id', 'name'), array('empty' => '(Select a division)', 'class' => 'span12 hot-key', 'maxlength' => 10));?>
		</div>
		<div class="span2">
			<label>&nbsp;</label>
			<?php echo GxHtml::htmlButton(Yii::t('app', 'Search'), array('type' => 'submit', 'class' => 'btn hot-key')); ?>
		</div>
		<div class="span2 offset2 text-right">
			<label>&nbsp;</label>
			<?php echo GxHtml::link('Create', array('/humanresources/create'), array('id' => 'hr-create', 'class' => 'btn hot-key', 'data-hot-key-action' => 'js', 'data-hot-key-js' => 'location = $(\'#hr-create\').attr(\'href\');')); ?>
		</div>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- search-form -->
