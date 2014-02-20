<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
	<?php echo GxHtml::encode($data->name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('short_name')); ?>:
	<?php echo GxHtml::encode($data->short_name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('image')); ?>:
	<?php echo GxHtml::encode($data->image); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('logo')); ?>:
	<?php echo GxHtml::encode($data->logo); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('icon')); ?>:
	<?php echo GxHtml::encode($data->icon); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('type')); ?>:
	<?php echo GxHtml::encode($data->type); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('params')); ?>:
	<?php echo GxHtml::encode($data->params); ?>
	<br />
	*/ ?>

</div>