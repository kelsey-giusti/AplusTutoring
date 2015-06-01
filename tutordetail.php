<!DOCTYPE html>
<html>

	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="UTF-8">

		<!-- Latest compiled and minified Bootstrap CSS -->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

		<!-- Latest compiled Bootstrap JavaScript -->
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

		<!-- Custom CSS -->
		<link rel="stylesheet" type="text/css" href="style/main.css">

		<!-- JavaScript Helpers -->
		<script>
			function getQueryVariable(variable)
			{
			       var query = window.location.search.substring(1);
			       var vars = query.split("&");
			       for (var i=0;i<vars.length;i++) {
			               var pair = vars[i].split("=");
			               if(pair[0] == variable){return pair[1];}
			       }
			       return(false);
			}
		</script>

		<!-- Scheduling JavaScript -->
		<script type="text/javascript">
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
							alert("Please select an open block to schedule a session or one of your sessions to cancel");
						}
					}
			});
		</script>

		<!-- Schedule Control JavaScript -->
		<script type="text/javascript">
			$(document).ready(function() {
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
		</script>

		<title>A+ Tutoring</title>

		<?php
			session_start();

			$name = "Profile";
			$profile = "loginform.php";
			if (isset($_SESSION['Name'])) {
				$name = $_SESSION['Name'];
				if($_SESSION['Type'] == 'Tutor') {
					$profile = "tutordashboard.php?location=0";
				} else if($_SESSION['Type'] == 'Admin') {
					$profile = "admindashboard.php?location=0";
				} else {
					$profile = "browsetutor.php";
				}
			}

			$log = "Login";
			$url = "loginform.php";
			if(isset($_SESSION['Name'])) {
				$log= "Logout";
				$url = "logout.php";
			}

			$back="";
			if($_GET['location'] < 1) {
				$back="inactive";
			}
		?>

		<!-- Get Data -->
		<?php
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "aplus";

			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);

			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}

			// Display correct tab
			$home = "active";
			$schedule = "";
			if(!empty($_GET["schedule"])) {
				$schedule = "active";
				$home = "";
			}

			// Get Tutor Data
			$id = htmlspecialchars($_GET["id"]);
			$sql = "SELECT UserID, Name, Image, FullDescription, Subjects, AvailableMonday, AvailableTuesday, AvailableWednesday, AvailableThursday, AvailableFriday, AvailableSaturday FROM tutor WHERE UserID = " . $id;
			$result = $conn->query($sql);
			$row = null;
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
			}

			// Get Dates
			$monday = date("D M d", strtotime($_GET['location']*7 . ' days' ,strtotime('monday this week')));
			$tuesday = date("D M d", strtotime($_GET['location']*7 . ' days' ,strtotime('tuesday this week')));
			$wednesday = date("D M d", strtotime($_GET['location']*7 . ' days' ,strtotime('wednesday this week')));
			$thursday = date("D M d", strtotime($_GET['location']*7 . ' days' ,strtotime('thursday this week')));
			$friday = date("D M d", strtotime($_GET['location']*7 . ' days' ,strtotime('friday this week')));
			$saturday = date("D M d", strtotime($_GET['location']*7 . ' days' ,strtotime('saturday this week')));

			$monday_title = date("M d", strtotime($_GET['location']*7 . ' days' ,strtotime('monday this week')));
			$saturday_title = date("M d", strtotime($_GET['location']*7 . ' days' ,strtotime('saturday this week')));

			$monday_db = date("Y-m-d", strtotime($_GET['location']*7 . ' days' ,strtotime('monday this week')));
			$saturday_db = date("Y-m-d", strtotime($_GET['location']*7 . ' days' ,strtotime('saturday this week')));

			// Get Student Names
			$sql = "SELECT UserID, Name FROM user WHERE Type = 'Student'";
			$result = $conn->query($sql);
			$students = array();
			if($result->num_rows > 0) {
				while($s = $result->fetch_assoc()){
			    	$students[$s['UserID']] = $s['Name'];
				}
			}

			// Get Availability
			$sql = "SELECT Day, Block FROM availability WHERE TutorID = " . $id . " ORDER BY Block, Day";
			$result = $conn->query($sql);
			$checks = array();
			for($i = 0; $i < 12; $i++) {
				$check = array();
				for($y = 0; $y < 6; $y++) {
					array_push($check, "");
				}
				array_push($checks, $check);
			}

			if($result->num_rows > 0) {
				while($a = $result->fetch_assoc()){
					$checks[$a['Block']-1][$a['Day']-1] = "checked";
				}
			}

			// Get Sessions
			$sql = "SELECT StudentID, Date, Block FROM session WHERE TutorID = " . $id . " AND Date BETWEEN '" . $monday_db . "' AND '" . $saturday_db . "' ORDER BY Block, Date";
			$result = $conn->query($sql);
			$blocks = array();
			for($i = 0; $i < 12; $i++) {
				$block = array();
				for($y = 0; $y < 6; $y++) {
					if($checks[$i][$y] == 'checked') {
						array_push($block, "open");
					} else {
						array_push($block, "unavailable");
					}
				}
				array_push($blocks, $block);
			}

			if($result->num_rows > 0) {
				while($session = $result->fetch_assoc()){
					$blocks[$session['Block']-1][date("w", strtotime($session['Date'])) - 1] = $students[$session['StudentID']];
				}
			}

			$conn->close();
		?>
	</head>

	<body>
		<input id="tutorID" type="hidden" name="tutorID" value="<?=$id?>">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div>
					<ul class="nav navbar-nav">
						<li><a href="home.php">Home</a></li>
						<li><a href="browsetutor.php">Tutors</a></li>
						<li><a href="contact.php">Contact Us</a></li> 
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a id="user" href="<?=$profile?>"><span class="glyphicon glyphicon-user"></span> <?=$name?></a></li>
						<li><a href="<?=$url?>"><span class="glyphicon glyphicon-log-in"></span> <?=$log?></a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container-fluid vertical-center" id="content">

			<img id="logo" src="images/logo.png" alt="logo" class=".img-responsive" />

			<div class="container">
				<h1 class="title" id="tutorName"><?=$row['Name']?></h1>
				<div class="right-tabs clearfix" >
				
                <ul class="nav nav-tabs" id="dashboard">
					<li class="<?=$home?>"><a href="#profile" data-toggle="tab">Profile</a></li>
                    <li class="<?=$schedule?>"><a href="#schedule" data-toggle="tab">Schedule</a></li>
                </ul>
				
                <div class="tab-content dashboard-tab">
				
					<div class="tab-pane <?=$home?>" id="profile">
                        <div class="row">
                            <div class="col-md-4">
								<img class="photoiddetails" src="images/<?=$row['Image']?>" alt="photoid" />
                            </div>
                            <div class="col-md-8">
                            	<h3 class="subtitle_right">Availability:</h3>
                           		<p>
                           			<?php
                           			echo " ".
                           				($row["AvailableMonday"] == 1 ? "Mon " : "").
										($row["AvailableTuesday"] == 1 ? "Tues " : "").
										($row["AvailableWednesday"] == 1 ? "Wed " : "").
										($row["AvailableThursday"] == 1 ? "Thurs " : "").
										($row["AvailableFriday"] == 1 ? "Fri " : "").
										($row["AvailableSaturday"] == 1 ? "Sat" : "")
                           			?>
                           		</p>	
                           		<h3 class="subtitle_right">Subjects:</h3>
                           		<p><?=$row['Subjects']?></p>				
								<h3 class= "subtitle_right">Biography:</h3>
								<p><?=$row['FullDescription']?></p>
                            </div>
                        </div>
                    </div>
				
                    <div class="tab-pane <?=$schedule?>" id="schedule">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="subtitle"><span class="<?=$back?>" id="back">&#9668</span> <?=$monday_title?> - <?=$saturday_title?> <span id="forward">&#9658</span></h3>
                                <div class="table-responsive">
									<table class="table table-striped table-bordered">
										<thead>
											<tr>
												<th></th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<th>" . $monday . "</th>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<th>" . $tuesday . "</th>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<th>" . $wednesday . "</th>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<th>" . $thursday . "</th>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<th>" . $friday . "</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<th>" . $saturday . "</th>";} ?>
											</tr>
										</thead>
										<tbody>
											<?
												$start = 8;
												$end = 9;
												for($i = 0; $i < 12; $i++) {
													echo "<tr>";
													echo "<th>" . $start . ":00 - " . $end . ":00" . "</th>";
													if ($row["AvailableMonday"] == 1) {echo "<td>" . $blocks[$i][0] . "</td>";}
													if ($row["AvailableTuesday"] == 1) {echo "<td>" . $blocks[$i][1] . "</td>";}
													if ($row["AvailableWednesday"] == 1) {echo "<td>" . $blocks[$i][2] . "</td>";}
													if ($row["AvailableThursday"] == 1) {echo "<td>" . $blocks[$i][3] . "</td>";}
													if ($row["AvailableFriday"] == 1) {echo "<td>" . $blocks[$i][4] . "</td>";}
													if ($row["AvailableSaturday"] == 1) {echo "<td>" . $blocks[$i][5] . "</td>";}
													echo "</tr>";
													$start ++;
													$end ++;
													if($start == 13) $start = 1;
													if($end == 13) $end = 1;
												}
											?>
										</tbody>
									</table>
								</div>
								<br />
								<p class="pull-right"><strong>Select a time to schedule or cancel a session.</strong></p>
                            </div>
                        </div>
                    </div>
                   					
                </div>
                </div>
			</div>
 
		</div>

	</body>

</html>