$(document).ready(function(){
	$('table').on('click', 'td', function(e) {
		if(getQueryVariable('location') >= 0) {
		    var day = $(e.delegateTarget.tHead.rows[0].cells[this.cellIndex]).text();
		    var block = $(this).parent().parent().children().index($(this).parent()) + 1;
		    var studentName = $(this).text();
				var tutorID = $('#tutorID').val();
				var tutorName = $('#tutorName').text();
		    
		    var user = $('#user').text().slice(1);
		    if(user === studentName || studentName === "open") {
		    	window.location.href = "schedule.php?name=" + tutorName + "&id=" + tutorID + "&day=" + day + "&block=" + block + "&student=" + studentName;
			} else {
				alert("Please select an open block to schedule a session or one of your sessions to cancel \n User: " + user);
			}
		}
	});
	$("#back").click(function() {
		if(getQueryVariable('location') > 0) {
			var location = parseInt(getQueryVariable('location')) - 1;
			window.location.href = "tutordetail.php?id=" + getQueryVariable('id') + "&location=" + location + "&schedule=true";
		}
	});
	$("#forward").click(function() {
		var location = parseInt(getQueryVariable('location')) + 1;
		window.location.href = "tutordetail.php?id=" + getQueryVariable('id') + "&location=" + location + "&schedule=true";
	});
});
