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
		clearTimeout(element.data("timing", null).data("timer"));
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

	$("#projects_list .wt-apply").click(function () {
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
				update_data.item.tooltip('destroy');
				if (data && data.status == 1 && (data.working_time || data.resource)) {
					//TODO: notification
					self.data("update-data", null);
					self.next().data("cancel-data", null);
					if (data.working_time)
						update_data.item.data("working-time", data.working_time);
					else /*if (data.resource)*/ {
						update_data.item.data("working-time", null);
						if (!update_data.resource && update_data.working_time)
							update_data.item.data("resource", update_data.working_time.resource);
					}
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
				update_data.item.tooltip('destroy');

				//TODO: notification
				revertTo(update_data.item, update_data.old_container);
			});

	});

	$("#projects_list .wt-cancel").click(function () {
		var self = $(this);
		var cancel_data = $(this).data("cancel-data");

		cancel_data.item.find(".edit-button").first().hide();
		cancel_data.item.tooltip('destroy');
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

			if (new_project_id > 0) {
				item.addClass("unsortable");
				$("#projects_list .item-list").sortable("refresh");
			}


			var new_project = $("#project_" + new_project_id).data("project");
			var join_start_time = new Date();
			if (new_project) {
				item.tooltip({
					title: "Will join " + new_project.name + " from " + join_start_time.format("mmm d, yyyy HH:MM")
				});
			} else {
				item.tooltip({
					title: "Will free from " + join_start_time.format("mmm d, yyyy HH:MM")
				});
			}

			if (!wt_apply.data("update-data"))
				wt_apply.data("update-data", {
					item: item,
					resource_id: resource_id,
					resource: /*working_time ? null : */JSON.stringify(resource),
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

			if (new_project_id) startCircle(7000, wt_apply);

			//$("#projects_list .item-list").sortable( "refresh" );
			//$("#projects_list .item-list").sortable( "cancel" );
		}
	});

	var circle_mouseleave_timer;
	$("#projects_list .unsortable").live("mouseenter", function () {
		clearTimeout(circle_mouseleave_timer);
		pauseAllCircle();
	}).live("mouseleave", function () {
			clearTimeout(circle_mouseleave_timer);
			circle_mouseleave_timer = setTimeout(function(){
				continueAllCircle();
			}, 500);
		});

	$("#dialog-form").removeClass("hide").dialog({
		autoOpen: false,
		width: 450,
		modal: true,
		buttons: {
			"Save": function () {
				//TODO:zzz
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
				var item = $(this).data("target");
				item.find(".wt-cancel:visible").first().click();
				$(this).dialog("close");
			}
		},
		open: function () {
			pauseAllCircle();
			/*var target = $(this).data("target");
			 var circle = target.find(".wt-apply").first();*/

			/*var start = dialog_start_time.datetimepicker('getDate');
			 if (start) dialog_end_time.datetimepicker('option', 'minDate', start);
			 else dialog_end_time.datetimepicker('option', 'minDate', null);*/
		},
		close: function () {
			/*var target = $(this).data("target");
			 var circle = target.find(".wt-apply").first();*/
			continueAllCircle();
		}
	});

	var dialog_start_time;

	function dialog_start_time_enable() {
		dialog_start_time = $("#dialog_start_time").datetimepicker({
			/*minDate: now,*/
			showWeek: true,
			dateFormat: 'M dd, yy',
			timeFormat: 'HH:mm',
			showOptions: { direction: "down" },
			onClose: function (dateText, inst) {
				if (dialog_end_time.val() != '') {
					var testStartDate = dialog_start_time.datetimepicker('getDate');
					var testEndDate = dialog_end_time.datetimepicker('getDate');
					if (testStartDate > testEndDate)
						dialog_end_time.datetimepicker('setDate', null);
				}
			},
			onSelect: function (selectedDateTime) {
				dialog_end_time.datetimepicker('option', 'minDate', dialog_start_time.datetimepicker('getDate'));
			}
		});
	}

	dialog_start_time_enable();

	var dialog_end_time = $("#dialog_end_time").datetimepicker({
		showWeek: true,
		dateFormat: 'M dd, yy',
		timeFormat: 'HH:mm',
		showOptions: { direction: "down" }
	});

	$("#projects_list .work-time-edit").click(function () {
		var self = $(this);
		var item = self.parents(".human-resource").first();
		var working_time = item.data("working-time");
		if (working_time) {
			var resource = working_time.resource;
			var old_project_id = working_time.project_id;
			var project = $("#project_" + old_project_id).data("project");
			$("#dialog_current_project_name").html(
				(project.short_name ? project.short_name : project.name) + " (" +
					phpDateFormat(parseInt(working_time.start_time)) +
					(parseInt(working_time.end_time) ? " ~ " + phpDateFormat(parseInt(working_time.end_time)) : "") + ")");
			$("#dialog_current_project").show();

			var current_start_time = new Date((($time_offset * 60 * 60) + parseInt(working_time.start_time)) * 1000);
			dialog_start_time.datetimepicker('setDate', current_start_time);
			var start = dialog_start_time.datetimepicker('getDate');
			if (start) dialog_end_time.datetimepicker('option', 'minDate', start);
			else dialog_end_time.datetimepicker('option', 'minDate', null);
			dialog_start_time.datetimepicker("destroy");
		} else {
			var old_project_id = 0;
			var current_start_time = new Date();
			var resource = item.data("resource");
			$("#dialog_current_project").hide();
		}

		var dialog_project_id = $("#dialog_project_id");
		dialog_project_id.find("option").show();
		dialog_project_id.val(dialog_project_id.find("option").first().attr("value"));
		if (old_project_id) {
			var current_option = dialog_project_id.find("option[value=" + old_project_id + "]").hide();
			if (dialog_project_id.val() == old_project_id) {
				dialog_project_id.val(current_option.next().attr("value"));
			}
			$("#dialog_role_id").val(4);
		} else {
			$("#dialog_role_id").val($roles[(working_time ? working_time.role_id : resource.role_id)]);
		}
		var new_project_id = item.parents(".view").first().data("project-id");
		if (new_project_id == old_project_id) {
			$("#move_to").attr({checked: false, disabled: false});
			dialog_project_id.attr("disabled", true);
		} else {
			$("#move_to").attr({checked: true, disabled: true});
			dialog_project_id.removeAttr("disabled");
			$("#dialog_project_id").val(new_project_id);

			dialog_start_time_enable();
			dialog_start_time.datetimepicker('option', 'minDate', current_start_time);
			dialog_start_time.datetimepicker('setDate', new Date());
			var start = dialog_start_time.datetimepicker('getDate');
			if (start) dialog_end_time.datetimepicker('option', 'minDate', start);
			else dialog_end_time.datetimepicker('option', 'minDate', null);
			dialog_end_time.datetimepicker('setDate', null);
		}

		$("#dialog_division").val($divisions[resource.division_id]);

		$("#dialog-form").data("target", item).dialog("open");
	});

	$("#end_time_remove").click(function () {
		dialog_end_time.datetimepicker('setDate', null);
	});

	$("#move_to").click(function () {
		var dialog_project_id = $("#dialog_project_id");
		if ($(this).is(":checked"))
			dialog_project_id.removeAttr("disabled");
		else
			dialog_project_id.attr("disabled", true);

	});
});