<?php
if (!isset($cs)) $cs = Yii::app()->getClientScript();
if (!isset($baseUrl)) $baseUrl = Yii::app()->theme->baseUrl;
$cs->registerScriptFile($baseUrl.'/js/hotkey.js');
$cs->registerScriptFile($baseUrl . '/js/user_form.js');
$redirect = Yii::app()->user->getState("Users_form_states_redirect", 0);
$saveTexts = array('', _SAVE_END_CLOSE, _SAVE_END_NEW);
?>
<div class="form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'users-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<div class="span3">
				<?php echo $form->labelEx($model,'username'); ?>
				<?php echo $form->textField($model, 'username', array('class' => 'span12 hot-key', 'maxlength' => 128)); ?>
				<?php echo $form->error($model,'username'); ?>
			</div>
			<div class="span3">
				<?php echo $form->labelEx($model,'password'); ?>
				<?php echo $form->passwordField($model, 'password', array('class' => 'span12 hot-key', 'maxlength' => 128)); ?>
				<?php echo $form->error($model,'password'); ?>
			</div>
		</div><!-- row -->
		<div class="row">
			<div class="span3">
				<?php echo $form->labelEx($model,'email'); ?>
				<?php echo $form->textField($model, 'email', array('class' => 'span12 hot-key', 'maxlength' => 128)); ?>
				<?php echo $form->error($model,'email'); ?>
			</div>
			<div class="span3">
				<?php echo $form->labelEx($model,'roles'); ?>
				<?php echo $form->dropDownList($model, 'roles', Yii::app()->params['userRoles'], array('empty' => '(Select a role)', 'class' => 'span12 hot-key')); ?>
				<?php echo $form->error($model,'roles'); ?>
			</div>
		</div><!-- row -->
		<div class="row">
			<div class="span3 offset2">
				<?php echo GxHtml::label('&nbsp;', null); ?>
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
				<input type="hidden" id="redirect" name="redirect" value="<?php echo $redirect; ?>">
			</div>
		</div>

<?php
$this->endWidget();
?>
</div><!-- form -->