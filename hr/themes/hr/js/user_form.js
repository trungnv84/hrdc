$(document).ready(function () {
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

	$("#users-form").validate({
		rules: {
			"Users[username]": {
				required: true,
				minlength: 2
			},
			"Users[password]": {
				/*required: true,*/
				minlength: 6
			},
			"Users[email]": {
				required: true,
				email: true
			},
			"Users[roles]": "required"
		},
		messages: {
			"Users[username]": {
				required: "Please enter a username",
				minlength: "Your username must consist of at least 2 characters"
			},
			"Users[password]": {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			"Users[email]": "Please enter a valid email address",
			"Users[roles]": "Please select a role"
		}
	});
});