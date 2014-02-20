$( document ).ready(function(){
	$("#search_query").select2({
		allowClear: true,
		placeholder: "Search",
		minimumInputLength: 1,
		ajax: {
			url: "humanResource/quickSearch",
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
				return {results: data};
			}
		}
	});
});