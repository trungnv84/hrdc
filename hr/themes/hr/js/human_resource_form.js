$(document).ready(function () {
	$("#HumanResources_username").select2({
		minimumInputLength: 1,
		placeholder: "Username",
		initSelection: function (element, callback) {
			var name = $(element).val();
			if (name != "") {
				var data = {id: name, text: name};
				callback(data);
			}
		},
		createSearchChoice: function (term, data) {
			return {id: term, name: term};
		},
		ajax: {
			url: "humanResource/usersSelection",
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
		}
	});
});