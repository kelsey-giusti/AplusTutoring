$(document).ready(function() {
	$("#back").click(function() {
		if(getQueryVariable('location') > 0) {
			var location = parseInt(getQueryVariable('location')) - 1;
			window.location.href = "tutordashboard.php?&location=" + location + "&schedule=true";
		}
	});
	$("#forward").click(function() {
		var location = parseInt(getQueryVariable('location')) + 1;
		window.location.href = "tutordashboard.php?&location=" + location + "&schedule=true";
	});
	$("#all").click(function() {
		if($(this).prop('checked')) {
			$("form input:checkbox").prop('checked', true);
		}
		$('#none').prop('checked', false);
	});
	$("#none").click(function() {
		if($(this).prop('checked')) {
			$("form input:checkbox").prop('checked', false);
		}
		$('#none').prop('checked', true);
	});
});