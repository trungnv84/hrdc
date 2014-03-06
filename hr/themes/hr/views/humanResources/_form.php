<?php
if (!isset($cs)) $cs = Yii::app()->getClientScript();
if (!isset($baseUrl)) $baseUrl = Yii::app()->theme->baseUrl;
$cs->registerCssFile($baseUrl.'/js/select2-3.4.5/select2.css');
$cs->registerScriptFile($baseUrl.'/js/select2-3.4.5/select2.js');
$cs->registerScriptFile($baseUrl.'/js/plupload-2.1.1/plupload.full.min.js');
$cs->registerScriptFile($baseUrl.'/js/hotkey.js');
$cs->registerScriptFile($baseUrl.'/js/human_resource_form.js');
$redirect = Yii::app()->user->getState("HumanResources_form_states_redirect", 0);
$saveTexts = array('', _SAVE_END_CLOSE, _SAVE_END_NEW);
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
			<?php echo $form->textField($model, 'employee_id', array('class' => 'span12 hot-key', 'maxlength' => 10)); ?>
			<?php echo $form->error($model, 'employee_id'); ?>
		</div>
		<div class="span3">
			<?php echo $form->labelEx($model, 'name'); ?>
			<?php echo $form->textField($model, 'name', array('class' => 'span12 hot-key', 'maxlength' => 60)); ?>
			<?php echo $form->error($model, 'name'); ?>
		</div>
		<div class="span2">
			<?php echo $form->labelEx($model, 'username', array('label' => 'User Account')); ?>
			<?php echo $form->textField($model, 'username', array('class' => 'span12 hot-key', 'maxlength' => 60,
				'data-hot-key-container' => '#s2id_HumanResources_username', 'data-hot-key-label' => 'User Account',
				'data-hot-key-action' => 'trigger', 'data-hot-key-trigger' => 'select2click')); ?>
			<?php echo $form->error($model, 'username'); ?>
			<?php echo $form->hiddenField($model, 'user_id'); ?>
		</div>
		<div class="span2">
			<?php echo $form->labelEx($model, 'division_id'); ?>
			<?php echo $form->dropDownList($model, 'division_id', CHtml::listData($divisions, 'id', 'name'), array('empty' => '(Select division)', 'class' => 'span12 hot-key', 'maxlength' => 10)); ?>
			<?php echo $form->error($model, 'division_id'); ?>
		</div>
		<div class="span3">
			<?php echo $form->labelEx($model, 'phone'); ?>
			<?php echo $form->textField($model, 'phone', array('class' => 'span12 hot-key')); ?>
			<?php echo $form->error($model, 'phone'); ?>
		</div>
	</div>
	<!-- row -->
	<div class="row">
		<div id="avatar_container" class="span3">
			<?php echo $form->labelEx($model, 'avatar'); ?>
			<?php echo $form->textField($model, 'avatar', array('class' => 'span12 hot-key', 'maxlength' => 250,
				'readonly' => true, 'data-hot-key-action' => 'trigger', 'data-hot-key-trigger' => 'focus,click')); ?>
			<?php echo $form->error($model, 'avatar'); ?>
		</div>
		<div class="span3">
			<?php echo $form->labelEx($model, 'email'); ?>
			<?php echo $form->textField($model, 'email', array('class' => 'span12 hot-key', 'maxlength' => 250)); ?>
			<?php echo $form->error($model, 'email'); ?>
		</div>
		<div class="span2">
			<?php echo $form->labelEx($model, 'skype'); ?>
			<?php echo $form->textField($model, 'skype', array('class' => 'span12 hot-key', 'maxlength' => 60)); ?>
			<?php echo $form->error($model, 'skype'); ?>
		</div>
		<div class="span3">
			<?php echo GxHtml::label('&nbsp;', null);?>
			<div id="btn-submit-group" class="btn-group">
				<?php
				echo GxHtml::htmlButton('Save' . @$saveTexts[$redirect], array('type' => 'submit', 'id' => 'btn-save',
					'class' => 'btn btn-primary hot-key', 'data-hot-key-code' => 's'));
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
			<input type="hidden" id="redirect" name="redirect" value="<?php echo $redirect;?>">
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