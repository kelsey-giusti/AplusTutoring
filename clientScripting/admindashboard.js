$(document).ready(function() {
	$("#back").click(function() {
		if(!$(this).hasClass('inactive')) {
			var location = parseInt(getQueryVariable('location')) - 1;
			window.location.href = "admindashboard.php?&location=" + location + "&schedule=true&back=true";
		}
	});
	$("#forward").click(function() {
		var location = parseInt(getQueryVariable('location')) + 1;
		window.location.href = "admindashboard.php?&location=" + location + "&schedule=true";
	});
});
