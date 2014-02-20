<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
	<?php echo GxHtml::encode($data->name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('user_id')); ?>:
	<?php echo GxHtml::encode($data->user_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('division_id')); ?>:
	<?php echo GxHtml::encode($data->division_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('avatar')); ?>:
	<?php echo GxHtml::encode($data->avatar); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('phone')); ?>:
	<?php echo GxHtml::encode($data->phone); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('email')); ?>:
	<?php echo GxHtml::encode($data->email); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('skype')); ?>:
	<?php echo GxHtml::encode($data->skype); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('position')); ?>:
	<?php echo GxHtml::encode($data->position); ?>
	<br />
	*/ ?>

</div>