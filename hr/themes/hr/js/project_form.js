$(document).ready(function () {
	/*var uploader = new plupload.Uploader({
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
						var codes = "A B C D E F G H I J K L M N O P Q R S T U V W X Y Z 0 1 2 3 4 5 6 7 8 9";
						if (event.keyCode == 13 || $.inArray(String.fromCharCode(event.keyCode), codes.split(" ")) > -1) {
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
				uploader.start();
			},

			BeforeUpload: function(up, file) {
				$("#btn-submit-group button.btn").attr("disabled", true);
			},

			*//*UploadFile: function(up, file) {
				console.log("UploadFile", up, file);
			},*//*

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
						"background: -moz-linear-gradient(left,  rgba(125,185,232,1) 0%, rgba(125,185,232," + up.total.percent / 100 + ") " + up.total.percent + "%, rgba(255,255,255," + up.total.percent / 100 + ") " + up.total.percent + "%, rgba(255,255,255,0) 100%); *//* FF3.6+ *//*" +
						"background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(125,185,232,1)), color-stop(" + up.total.percent + "%,rgba(125,185,232," + up.total.percent / 100 + ")), color-stop(" + up.total.percent + "%,rgba(255,255,255," + up.total.percent / 100 + ")), color-stop(100%,rgba(255,255,255,0))); *//* Chrome,Safari4+ *//*" +
						"background: -webkit-linear-gradient(left,  rgba(125,185,232,1) 0%,rgba(125,185,232," + up.total.percent / 100 + ") " + up.total.percent + "%,rgba(255,255,255," + up.total.percent / 100 + ") " + up.total.percent + "%,rgba(255,255,255,0) 100%); *//* Chrome10+,Safari5.1+ *//*" +
						"background: -o-linear-gradient(left,  rgba(125,185,232,1) 0%,rgba(125,185,232," + up.total.percent / 100 + ") " + up.total.percent + "%,rgba(255,255,255," + up.total.percent / 100 + ") " + up.total.percent + "%,rgba(255,255,255,0) 100%); *//* Opera 11.10+ *//*" +
						"background: -ms-linear-gradient(left,  rgba(125,185,232,1) 0%,rgba(125,185,232," + up.total.percent / 100 + ") " + up.total.percent + "%,rgba(255,255,255," + up.total.percent / 100 + ") " + up.total.percent + "%,rgba(255,255,255,0) 100%); *//* IE10+ *//*" +
						"background: linear-gradient(to right,  rgba(125,185,232,1) 0%,rgba(125,185,232," + up.total.percent / 100 + ") " + up.total.percent + "%,rgba(255,255,255," + up.total.percent / 100 + ") " + up.total.percent + "%,rgba(255,255,255,0) 100%); *//* W3C *//*" +
						"filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7db9e8', endColorstr='#00ffffff',GradientType=1 ); *//* IE6-9 *//*"
				);
			},

			UploadComplete: function (up, files) {
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
	});*/

	/*uploader.init();*/

	$("#Projects_name").focus().focusin();

	$("#Projects_discovery_phase_starts, #Projects_development_phase_starts, " +
		"#Projects_end_development_phase_starts, #Projects_uat_phase_starts").datepicker({
		showOtherMonths: true,
		selectOtherMonths: true,
		dateFormat: 'dd-mm-yy'
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