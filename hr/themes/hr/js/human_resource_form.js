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
		}, formatResult: function (object, container, query) {
			return object.username;
		},
		formatSelection: function (object, container) {
			return object.username;
		}
	}).change(function(event){
			if($.isNumeric(event.added.id)) {
				$("#HumanResources_user_id").val(event.added.id);
			} else {
				$("#HumanResources_user_id").val("0");
			}
		});

	var uploader = new plupload.Uploader({
		runtimes : 'html5,flash,silverlight,html4',

		browse_button : 'HumanResources_avatar', // you can pass in id...
		container: document.getElementById('avatar_container'), // ... or DOM Element itself

		url : $("base").first().attr("href") + "humanResources/uploadAvatar",

		dragdrop: true,
		chunk_size : '100kb',
		multi_selection: false,

		filters : {
			max_file_size : '3mb',
			mime_types: [
				{title : "Image files", extensions : "jpg,gif,png"}
			]
		},

		// Flash settings
		flash_swf_url : 'js/plupload-2.1.1/Moxie.swf',

		// Silverlight settings
		silverlight_xap_url : 'js/plupload-2.1.1/Moxie.xap',

		init: {
			PostInit: function() {
				document.getElementById('HumanResources_avatar').onclick = function() {
					uploader.start();
					return false;
				};
			},

			FilesAdded: function(up, files) {
				plupload.each(files, function(file) {
					$(uploader.settings.browse_button).val(file.name);
				});
				uploader.start();
			},

			UploadProgress: function(up, file) {
				console.log(up.total.percent);
			},

			Error: function(up, err) {
				//document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
			}
		}
	});

	uploader.init();
});