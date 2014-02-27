$(document).ready(function () {
	$("#HumanResources_username").select2({
		id: 'username',
		minimumInputLength: 1,
		placeholder: "Username",
		initSelection: function (element, callback) {
			var name = $(element).val();
			if (name != "") {
				var data = {id: name, username: name};
				callback(data);
			}
		},
		createSearchChoice: function (term, data) {
			return {id: term, username: term};
		},
		ajax: {
			url: "humanResources/usersSelection",
			dataType: 'json',
			data: function (term, page) {
				return {
					q: term, // search term
					limit: 10,
					offset: (page - 1) * 10
				};
			},
			results: function (data, page) {
				// parse the results into the format expected by Select2.
				// since we are using custom formatting functions we do not need to alter remote JSON data
				return {results: data.users};
			}
		},
		formatResult: function (object, container, query) {
			return object.username;
		},
		formatSelection: function (object, container) {
			return object.username;
		}
	}).change(function (event) {
			if ($.isNumeric(event.added.id)) {
				$("#HumanResources_user_id").val(event.added.id);
			} else {
				$("#HumanResources_user_id").val("0");
			}
		}).on("select2-opening",function (event) {
			$(event.currentTarget).data("opening", 1);
		}).on("select2-close", function (event) {
			$(event.currentTarget).data("opening", 0);
		});

	$("#select2-drop input.select2-input").live("keyup", function (event) {
		if ($("#HumanResources_username").data("opening") && event.key == "Enter" && event.keyCode == 13) {
			event.preventDefault();
			var term = $(this).val();
			$("#HumanResources_username").select2("close");
			$("#HumanResources_username").select2("data", {id: term, username: term});
		}
	});

	var uploader = new plupload.Uploader({
		runtimes: 'html5,flash,silverlight,html4',

		browse_button: 'HumanResources_avatar', // you can pass in id...
		container: document.getElementById('avatar_container'), // ... or DOM Element itself

		url: $("base").first().attr("href") + "humanResources/uploadAvatar",

		dragdrop: true,
		chunk_size: '100kb',
		multi_selection: false,

		filters: {
			max_file_size: '3mb',
			mime_types: [
				{title: "Image files", extensions: "jpg,gif,png"}
			]
		},

		// Flash settings
		flash_swf_url: 'js/plupload-2.1.1/Moxie.swf',

		// Silverlight settings
		silverlight_xap_url: 'js/plupload-2.1.1/Moxie.xap',

		init: {
			PostInit: function () {
				//console.log(this.settings.container);
				$(this.settings.container).find("input[type=file]").attr('tabindex', '-1');

				$("#HumanResources_avatar").click(function () {
					uploader.start();
				}).keypress(function (event) {
						if (event.key == "Enter" && event.keyCode == 13) {
							event.preventDefault();
							$(this).click();
						}
					});
			},

			FilesAdded: function (up, files) {
				plupload.each(files, function (file) {
					$(uploader.settings.browse_button).val(file.name);
				});
				uploader.start();
			},

			UploadProgress: function (up, file) {
				//console.log(up.total.percent);
				$('#HumanResources_avatar').attr("style",
					"position: relative; z-index: 1;" +
						"background: -moz-linear-gradient(left,  rgba(125,185,232,1) 0%, rgba(125,185,232," + up.total.percent / 100 + ") " + up.total.percent + "%, rgba(255,255,255," + up.total.percent / 100 + ") " + up.total.percent + "%, rgba(255,255,255,0) 100%); /* FF3.6+ */" +
						"background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(125,185,232,1)), color-stop(" + up.total.percent + "%,rgba(125,185,232," + up.total.percent / 100 + ")), color-stop(" + up.total.percent + "%,rgba(255,255,255," + up.total.percent / 100 + ")), color-stop(100%,rgba(255,255,255,0))); /* Chrome,Safari4+ */" +
						"background: -webkit-linear-gradient(left,  rgba(125,185,232,1) 0%,rgba(125,185,232," + up.total.percent / 100 + ") " + up.total.percent + "%,rgba(255,255,255," + up.total.percent / 100 + ") " + up.total.percent + "%,rgba(255,255,255,0) 100%); /* Chrome10+,Safari5.1+ */" +
						"background: -o-linear-gradient(left,  rgba(125,185,232,1) 0%,rgba(125,185,232," + up.total.percent / 100 + ") " + up.total.percent + "%,rgba(255,255,255," + up.total.percent / 100 + ") " + up.total.percent + "%,rgba(255,255,255,0) 100%); /* Opera 11.10+ */" +
						"background: -ms-linear-gradient(left,  rgba(125,185,232,1) 0%,rgba(125,185,232," + up.total.percent / 100 + ") " + up.total.percent + "%,rgba(255,255,255," + up.total.percent / 100 + ") " + up.total.percent + "%,rgba(255,255,255,0) 100%); /* IE10+ */" +
						"background: linear-gradient(to right,  rgba(125,185,232,1) 0%,rgba(125,185,232," + up.total.percent / 100 + ") " + up.total.percent + "%,rgba(255,255,255," + up.total.percent / 100 + ") " + up.total.percent + "%,rgba(255,255,255,0) 100%); /* W3C */" +
						"filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7db9e8', endColorstr='#00ffffff',GradientType=1 ); /* IE6-9 */"
				);
				if (up.total.percent >= 100) {
					setTimeout(function () {
						$('#HumanResources_avatar').attr("style", "position: relative; z-index: 1;");
					}, 1500);
				}
			},

			Error: function (up, err) {
				//document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
			}
		}
	});

	uploader.init();

	$("#HumanResources_employee_id").focus().focusin();

	$("#HumanResources_username").bind("select2click", function(){
		$("#s2id_HumanResources_username .select2-focusser").focus().focusin();
		$(this).select2("open");
	});

	$("#btn-save-close").click(function(){
		$("#redirect").val(1);
		$("#btn-save").click();
	});

	$("#btn-save-new").click(function(){
		$("#redirect").val(2);
		$("#btn-save").click();
	});

	$("#btn-save-edit").click(function(){
		$("#redirect").val(0);
		$("#btn-save").click();
	});
});