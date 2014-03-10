<?php
$human_resources = ViewHelper::getWorkerInProject($data->id);
?>
<div class="view" data-project-id="<?php echo $data->id; ?>">
	<h4>
		<img src="<?php echo ViewHelper::projectIcon($data); ?>">
		<?php echo GxHtml::encode($data->name); ?>
	</h4>
	<span class="label label-info pull-right"><?php echo GxHtml::encode($data->short_name); ?></span>

	<?php foreach ($human_resources as $human_resource): ?>

		<div class="human-resource">
			<?php echo $human_resource->resource->username ? $human_resource->resource->username : $human_resource->resource->name . " ($human_resource->resource->employee_id)"; ?>
		</div>

	<?php endforeach; ?>
</div>