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
	<?php echo GxHtml::encode($data->getAttributeLabel('billable_effort')); ?>:
	<?php echo GxHtml::encode($data->billable_effort); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('total_effort')); ?>:
	<?php echo GxHtml::encode($data->total_effort); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('actual_effort')); ?>:
	<?php echo GxHtml::encode($data->actual_effort); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('discovery_phase_starts')); ?>:
	<?php echo GxHtml::encode($data->discovery_phase_starts); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('development_phase_starts')); ?>:
	<?php echo GxHtml::encode($data->development_phase_starts); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('end_development_phase_starts')); ?>:
	<?php echo GxHtml::encode($data->end_development_phase_starts); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('uat_phase_starts')); ?>:
	<?php echo GxHtml::encode($data->uat_phase_starts); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('resources')); ?>:
	<?php echo GxHtml::encode($data->resources); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('ordering')); ?>:
	<?php echo GxHtml::encode($data->ordering); ?>
	<br />
	*/ ?>

</div>