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
});