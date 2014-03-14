$(document).ready(function () {
	function phpDateFormat($time) {
		$time = new Date((($time_offset * 60 * 60) + $time) * 1000);
		return $time.format("mediumDate");
	}

	function startCircle(time, element) {
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
		var deg = Math.ceil(380 * percent) - 90;

		if (percent < 0.25) {
			element_css = "border-color: #ffffff;";
			after_css = "border-color: transparent #ffffff #ffffff;"
		} else if (percent < 0.50) {
			element_css = "border-color: #92EB00 #ffffff #ffffff;";
			after_css = "border-color: transparent transparent #ffffff #ffffff;"
		} else if (percent < 0.75) {
			element_css = "border-color: #92EB00 #92EB00 #ffffff #ffffff;";
			after_css = "border-color: transparent transparent transparent #ffffff;"
		} else {
			element_css = "border-color: #92EB00 #92EB00 #92EB00 #ffffff;"
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

		element.data("timing", time);

		if (time > 0) {
			element.data("timer", setTimeout(function () {
				startCircle(time, element)
			}, 100));
		} else {
			element.click();
		}
	}

	function stopCircle(element) {
		clearTimeout(element.data("timer"));
		var newClass = element.data("circle-class");
		element.removeClass("circle-" + newClass).data("time", 0);
		$("#circle-style-" + newClass).remove();
	}

	function pauseCircle(element) {
		clearTimeout(element.data("timer"));
	}

	function continueCircle(element) {
		var timing = element.data("timing");
		if (timing) startCircle(timing, element);
	}

	function pauseAllCircle() {
		$("#projects_list .wt-apply").each(function (index, element) {
			pauseCircle($(element));
		});
	}

	function continueAllCircle() {
		$("#projects_list .wt-apply").each(function (index, element) {
			continueCircle($(element));
		});
	}

	function revertTo(element, container) {
		var child = container.find(">").last();
		if (child.length > 0) {
			var pos = child.offset();
			var nx = pos.left;
			var ny = pos.top + child.outerHeight();
		} else {
			var pos = container.offset();
			var nx = pos.left;
			var ny = pos.top;
		}

		var pos = element.offset();
		var ox = pos.left;
		var oy = pos.top;

		element.css({
			height: element.height(),
			width: element.width(),
			position: "absolute"
		});

		element.animate(
			{
				left: nx - ox,
				top: ny - oy
			}, null, null,
			function () {
				container.append(element.detach().removeAttr("style"));
				if (element.hasClass("unsortable")) {
					element.removeClass("unsortable");
					$("#projects_list .item-list").sortable("refresh");
				}
			}
		);
	}

	$("#projects_list .wt-apply").live("click", function () {
		var self = $(this);

		var update_data = self.data("update-data");
		update_data.item.find(".edit-button").first().hide();
		stopCircle(self);

		var editBtn = update_data.item.find(".work-time-edit").first().addClass("hiding");
		var busyIco = update_data.item.find(".saving-busy").first().show();
		$.post(
			"resourceallocation/updateWorkingTime",
			{
				resource: update_data.resource,
				resource_id: update_data.resource_id,
				working_time: update_data.working_time,
				new_project_id: update_data.new_project_id
			},
			function (data) {
				busyIco.hide();
				editBtn.removeClass("hiding");
				if (data && data.status == 1 && (data.working_time || data.resource)) {
					//TODO: notification
					self.data("update-data", null);
					self.next().data("cancel-data", null);
					if (data.working_time)
						update_data.item.data("working-time", data.working_time);
					else if (data.resource)
						update_data.item.data("resource", data.resource);
					if (update_data.item.hasClass("unsortable")) {
						update_data.item.removeClass("unsortable");
						$("#projects_list .item-list").sortable("refresh");
					}
				} else {
					//TODO: notification
					revertTo(update_data.item, update_data.old_container);
				}
			},
			"json"
		).fail(function () {
				busyIco.hide();
				editBtn.removeClass("hiding");

				//TODO: notification
				revertTo(update_data.item, update_data.old_container);
			});

	});

	$("#projects_list .wt-cancel").live("click", function () {
		var self = $(this);
		var cancel_data = $(this).data("cancel-data");

		cancel_data.item.find(".edit-button").first().hide();
		stopCircle(self.prev());

		revertTo(cancel_data.item, cancel_data.old_container);
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

			var old_container = $(ui.sender);
			var oldProject = $(ui.sender).parents(".view").first();
			var newProject = item.parents(".view").first();

			var working_time = item.data("working-time");
			if (working_time) {
				var resource_id = working_time.resource_id;
				var resource = working_time.resource;
			} else {
				var resource = item.data("resource");
				var resource_id = resource.id;
			}
			var old_project_id = oldProject.data("project-id");
			var new_project_id = newProject.data("project-id");

			if (!wt_apply.data("update-data"))
				wt_apply.data("update-data", {
					item: item,
					resource_id: resource_id,
					resource: working_time ? null : JSON.stringify(resource),
					working_time: working_time ? JSON.stringify(working_time) : null,
					new_project_id: new_project_id,
					old_project_id: old_project_id,
					old_container: old_container
				});

			if (old_project_id > 0 || !wt_cancel.data("cancel-data"))
				wt_cancel.data("cancel-data", {
					item: item,
					old_project_id: old_project_id,
					old_container: old_container
				});

			if (new_project_id > 0) {
				item.addClass("unsortable");
				$("#projects_list .item-list").sortable("refresh");
			}

			if (new_project_id) startCircle(5000, wt_apply);

			//$("#projects_list .item-list").sortable( "refresh" );
			//$("#projects_list .item-list").sortable( "cancel" );
		}
	});

	$("#dialog-form").removeClass("hide").dialog({
		autoOpen: false,
		height: 320,
		width: 450,
		modal: true,
		buttons: {
			"Save": function () {
				var bValid = true;

				if (bValid) {
					$("#users tbody").append("<tr>" +
						"<td>" + name.val() + "</td>" +
						"<td>" + email.val() + "</td>" +
						"<td>" + password.val() + "</td>" +
						"</tr>");
					$(this).dialog("close");
				}
			},
			Close: function (event, ui) {
				$(this).dialog("close");
			},
			Cancel: function () {
				$(this).dialog("close");
			}
		},
		open: function () {
			/*var target = $(this).data("target");
			 var circle = target.find(".wt-apply").first();*/
			pauseAllCircle();
		},
		close: function () {
			/*var target = $(this).data("target");
			 var circle = target.find(".wt-apply").first();*/
			continueAllCircle();
		}
	});

	var range_date_time = $(".date-time-picker");
	var start_time = range_date_time.first().datetimepicker().on('changeDate', function(ev) {
		if (ev.date.valueOf() > end_time.date.valueOf()) {
			var newDate = new Date(ev.date)
			newDate.setDate(newDate.getDate() + 1);
			end_time.setValue(newDate);
		}
		start_time.hide();
		range_date_time.last().focus();
	});
	var end_time = range_date_time.last().datetimepicker({
		onRender: function(date) {
			return date.valueOf() <= start_time.date.valueOf() ? 'disabled' : '';
		}
	});
	$(".date-time-picker input").focusin(function(){
		$(this).next().click();
	});

	$("#projects_list .work-time-edit").live("click", function () {
		var self = $(this);
		var item = self.parents(".human-resource").first();
		var working_time = item.data("working-time");
		if (working_time) {
			var resource = working_time.resource;
			var project = $("#project_" + working_time.project_id).data("project");
			$("#form_current_project_name").html(
				(project.short_name ? project.short_name : project.name) + " (" +
					phpDateFormat(parseInt(working_time.start_time)) +
					(parseInt(working_time.end_time) ? " ~ " + phpDateFormat(parseInt(working_time.end_time)) : "") + ")");

			$("#form_current_project").show();
		} else {
			var resource = item.data("resource");
			$("#form_current_project").hide();
		}
		$("#form_division").val($divisions[resource.division_id]);


		$("#dialog-form").data("target", item).dialog("open");
	});
});