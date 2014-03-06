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

	var humanResources_avatar_uploader = new plupload.Uploader({
		runtimes: 'html5,flash,silverlight,html4',

		browse_button: 'HumanResources_avatar', // you can pass in id...
		container: document.getElementById('avatar_container'), // ... or DOM Element itself

		url: $("base").first().attr("href") + "humanResources/uploadImages?type=avatar",

		dragdrop: true,
		drop_element: 'HumanResources_avatar',
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
			PostInit: function (up) {
				//console.log(up.settings.container);
				$(up.settings.container).find("input[type=file]").attr('tabindex', '-1');

				$(up.settings.browse_button).click(function () {
					up.start();
				}).keyup(function (event) {
						var codes = "A B C D E F G H I J K L M N O P Q R S T U V W X Y Z 0 1 2 3 4 5 6 7 8 9";
						if (event.keyCode == 13 || $.inArray(String.fromCharCode(event.keyCode), codes.split(/\s+/)) > -1) {
							event.preventDefault();
							$(this).click();
						}
					});
			},

			FilesAdded: function (up, files) {
				$("#btn-submit-group button.btn").attr("disabled", false);
				var avatar = $(up.settings.browse_button);
				plupload.each(files, function (file) {
					avatar.data("val", avatar.val());
					avatar.val(file.name);
				});
				up.start();
			},

			BeforeUpload: function(up, file) {
				$("#btn-submit-group button.btn").attr("disabled", true);
			},

			/*UploadFile: function(up, file) {
				console.log("UploadFile", up, file);
			},*/

			ChunkUploaded: function(up, file, part) {
				var avatar = $(up.settings.browse_button);
				avatar.val($.parseJSON(part.response).result);
			},

			FileUploaded: function(up, file, part) {
				var avatar = $(up.settings.browse_button);
				avatar.val($.parseJSON(part.response).result);
			},

			UploadProgress: function (up, file) {
				var avatar = $(up.settings.browse_button);
				avatar.attr("style",
					"position: relative; z-index: 1;" +
						"background: -moz-linear-gradient(left,  rgba(125,185,232,1) 0%, rgba(125,185,232," + file.percent / 100 + ") " + file.percent + "%, rgba(255,255,255," + file.percent / 100 + ") " + file.percent + "%, rgba(255,255,255,0) 100%); /* FF3.6+ */" +
						"background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(125,185,232,1)), color-stop(" + file.percent + "%,rgba(125,185,232," + file.percent / 100 + ")), color-stop(" + file.percent + "%,rgba(255,255,255," + file.percent / 100 + ")), color-stop(100%,rgba(255,255,255,0))); /* Chrome,Safari4+ */" +
						"background: -webkit-linear-gradient(left,  rgba(125,185,232,1) 0%,rgba(125,185,232," + file.percent / 100 + ") " + file.percent + "%,rgba(255,255,255," + file.percent / 100 + ") " + file.percent + "%,rgba(255,255,255,0) 100%); /* Chrome10+,Safari5.1+ */" +
						"background: -o-linear-gradient(left,  rgba(125,185,232,1) 0%,rgba(125,185,232," + file.percent / 100 + ") " + file.percent + "%,rgba(255,255,255," + file.percent / 100 + ") " + file.percent + "%,rgba(255,255,255,0) 100%); /* Opera 11.10+ */" +
						"background: -ms-linear-gradient(left,  rgba(125,185,232,1) 0%,rgba(125,185,232," + file.percent / 100 + ") " + file.percent + "%,rgba(255,255,255," + file.percent / 100 + ") " + file.percent + "%,rgba(255,255,255,0) 100%); /* IE10+ */" +
						"background: linear-gradient(to right,  rgba(125,185,232,1) 0%,rgba(125,185,232," + file.percent / 100 + ") " + file.percent + "%,rgba(255,255,255," + file.percent / 100 + ") " + file.percent + "%,rgba(255,255,255,0) 100%); /* W3C */" +
						"filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7db9e8', endColorstr='#00ffffff',GradientType=1 ); /* IE6-9 */"
				);
			},

			UploadComplete: function (up, files) {
				var avatar = $(up.settings.browse_button);
				setTimeout(function () {
					avatar.attr("style", "position: relative; z-index: 1;");
				}, 1500);
				$("#btn-submit-group button.btn").attr("disabled", false);
			},

			Error: function (up, err) {
				var avatar = $(up.settings.browse_button);
				avatar.val(avatar.data("val"));
				alert("Upload Avatar Error #" + err.code + ": " + err.message);
				$("#btn-submit-group button.btn").attr("disabled", false);
			}
		}
	});

	humanResources_avatar_uploader.init();

	$("#HumanResources_employee_id").focus().focusin();

	$("#HumanResources_username").bind("select2click", function () {
		$("#s2id_HumanResources_username .select2-focusser").focus().focusin();
		$(this).select2("open");
	});

	$("#btn-save-close").click(function () {
		$("#redirect").val(1);
		$("#btn-save").click();
	});

	$("#btn-save-new").click(function () {
		$("#redirect").val(2);
		$("#btn-save").click();
	});

	$("#btn-save-edit").click(function () {
		$("#redirect").val(0);
		$("#btn-save").click();
	});
});