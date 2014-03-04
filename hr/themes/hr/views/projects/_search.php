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
			<?php echo GxHtml::label('Search', 'search_text'); ?>
			<?php echo GxHtml::textField('search[text]', null, array('class' => 'span12 hot-key', 'maxlength' => 120)); ?>
		</div>
		<div class="span2">
			<?php echo $form->label($model, 'type'); ?>
			<?php echo $form->dropDownList($model, 'type', Yii::app()->params['projectTypes'], array('empty' => '(Select a type)', 'class' => 'span12', 'maxlength' => 10)); ?>
		</div>
		<div class="span2">
			<label>&nbsp;</label>
			<?php echo GxHtml::htmlButton(Yii::t('app', 'Search'), array('type' => 'submit', 'class' => 'btn')); ?>
		</div>
		<div class="span2 offset3 text-right">
			<label>&nbsp;</label>
			<?php echo GxHtml::link('Create', array('/resourceallocation/create'), array('class' => 'btn')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
