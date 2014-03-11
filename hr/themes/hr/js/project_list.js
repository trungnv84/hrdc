$(document).ready(function () {
	$("#projects_list .item-list").sortable({
		connectWith: "#projects_list .item-list",
		placeholder: "ui-state-highlight",
		revert: true,
		receive: function( event, ui ) {
			//console.log(event, ui);
			var item = $(ui.item);
			var oldProject = $(ui.sender).parents(".view").first();
			var newProject = item.parents(".view").first();



		}
	});
});