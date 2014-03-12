$(document).ready(function () {
	function timer(time, element) {
		var start = element.data("time");
		if (!start) {
			start = time;
			var newClass = new Date().getTime();
			element.addClass("circle-" + newClass).data("circle-class", newClass).data("time", time);
			var style = $("<style id='circle-style-" + newClass + "'></style>");
			$("head").append(style);
		} else {
			var newClass = element.data("circle-class");
			var style = $("#circle-style-" + newClass);
		}

		time = time - 100;
		var percent = 1 - (time / start);
		var element_css, before_css, after_css;
		var deg = Math.ceil(360 * percent) - 90;

		if (percent < 0.25) {
			element_css = "border-color: #92EB00;";
			after_css = "border-color: transparent #92EB00 #92EB00;"
		} else if (percent < 0.50) {
			element_css = "border-color: transparent #92EB00 #92EB00;";
			after_css = "border-color: transparent transparent #92EB00 #92EB00;"
		} else if (percent < 0.75) {
			element_css = "border-color: transparent transparent #92EB00 #92EB00;";
			after_css = "border-color: transparent transparent transparent #92EB00;"
		} else {
			element_css = "border-color: transparent transparent transparent #92EB00;"
			after_css = "border-color: transparent"
		}

		element_css = "#projects_list .edit-button .circle-" + newClass + "{" + element_css + "}\n";

		before_css = "#projects_list .edit-button .circle-" + newClass + ":before{" +
			"-moz-transform: rotate(" + deg + "deg);" +
			"-webkit-transform: rotate(" + deg + "deg);" +
			"-o-transform: rotate(" + deg + "deg);" +
			"-ms-transform: rotate(" + deg + "deg);" +
			"transform: rotate(" + deg + "deg);" +
			"}\n";

		after_css = "#projects_list .edit-button .circle-" + newClass + ":after{" + after_css + "}\n";

		style.text(element_css + before_css + after_css);

		if (time > 0) {
			element.data("timer", setTimeout(function () {
				timer(time, element)
			}, 100));
		} else {
			element.click();
		}
	}

	function stop(self) {
		clearTimeout(self.data("timer"));
		var newClass = self.data("circle-class");
		self.removeClass("circle-" + newClass).data("time", 0);
		$("#circle-style-" + newClass).remove();
	}

	$("#projects_list .wt-apply").live("click", function () {
		var self = $(this);

		var update_data = self.data("update-data");
		update_data.item.find(".edit-button").first().hide();
		stop(self);

		//TODO: AJAX...

		update_data.item.removeClass("unsortable");
		$("#projects_list .item-list").sortable("refresh");
	});

	$("#projects_list .item-list").sortable({
		connectWith: "#projects_list .item-list",
		placeholder: "ui-state-highlight",
		items: "> div:not(.unsortable)",
		cancel: "a,button",
		revert: true,
		receive: function (event, ui) {
			//console.log(event, ui);
			var item = $(ui.item);

			item.find(".edit-button").first().css("display", "inline-block");
			var wt_apply = item.find(".wt-apply").first();
			var wt_cancel = item.find(".wt-cancel").first();

			var oldProject = $(ui.sender).parents(".view").first();
			var newProject = item.parents(".view").first();

			var working_time = item.data("working-time");
			if (working_time) {
				var resource_id = working_time.resource_id;
			} else {
				var resource = item.data("resource");
				var resource_id = resource.id;
			}
			var new_project = newProject.data("project-id");

			wt_apply.data("update-data", {
				item: item,
				resource_id: resource_id,
				working_time: JSON.stringify(working_time),
				new_project: new_project
			});

			wt_cancel.data("cancel-data", {
				item: item,
				oldContainer: $(ui.sender)
			});

			item.addClass("unsortable");
			$("#projects_list .item-list").sortable("refresh");

			timer(5000, wt_apply);

			//$("#projects_list .item-list").sortable( "refresh" );
			//$("#projects_list .item-list").sortable( "cancel" );

			/*$.post(
			 "resourceallocation/updateWorkingTime",
			 {
			 resource_id: resource_id,
			 working_time: JSON.stringify(working_time),
			 new_project: new_project
			 },
			 function(data){

			 },
			 "json"
			 );*/

		}
	});
});