<?php
$human_resources = ViewHelper::getWorkerInProject($data->id);
?>
<div id="project_<?php echo $data->id; ?>" class="view" data-project-id="<?php echo $data->id; ?>" data-project="<?php echo GxHtml::encode(json_encode($data->getAttributes())); ?>">
	<h4>
		<img src="<?php echo ViewHelper::projectIcon($data); ?>">
		<?php echo GxHtml::encode($data->name); ?>
	</h4>
	<span class="label <?php echo $data->type != 1 ? 'label-info' : 'label-success' ?> pull-right">
		<?php echo GxHtml::encode($data->short_name); ?></span>

	<div class="item-list">
		<?php foreach ($human_resources as $human_resource): ?>

			<div class="human-resource" data-working-time="<?php echo GxHtml::encode(json_encode($human_resource)); ?>">
				<?php echo $human_resource->resource->username ? $human_resource->resource->username : $human_resource->resource->name . " ({$human_resource->resource->employee_id})"; ?>
				<div class="edit-button">
					<a class="wt-apply" href="javascript:;" title="Apply">
						<i class="icon icon-ok"></i></a>
					<a class="wt-cancel" href="javascript:;" title="Cancel">
						<i class="icon icon-remove"></i></a>
				</div>
				<div class="pull-right saving-busy" title="Saving..."><!--&nbsp;&nbsp;s--></div>
				<a class="pull-right work-time-edit" href="javascript:;" title="Modify">
					<i class="icon icon-edit"></i></a>
			</div>

		<?php endforeach; ?>
	</div>
</div>