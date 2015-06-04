$(document).ready(function() {
	if(getQueryVariable('error') == 'true') {
		$("#error").show();
	} else {
		$("#error").hide();
	}
});