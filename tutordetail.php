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

		<!-- Scheduling JavaScript -->
		<script type="text/javascript">
			$(document).ready(function(){
				$('table').on('click', 'td', function(e) {  
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
				})
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
					$profile = "tutordashboard.php";
				} else if($_SESSION['Type'] == 'Admin') {
					$profile = "admindashboard.php";
				} else {
					$profile = "home.php";
				}
			}

			$log = "Login";
			$url = "loginform.php";
			if(isset($_SESSION['Name'])) {
				$log= "Logout";
				$url = "logout.php";
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
			$monday = date("D M d", strtotime('monday this week'));
			$tuesday = date("D M d", strtotime('tuesday this week'));
			$wednesday = date("D M d", strtotime('wednesday this week'));
			$thursday = date("D M d", strtotime('thursday this week'));
			$friday = date("D M d", strtotime('friday this week'));
			$saturday = date("D M d", strtotime('saturday this week'));

			$monday_title = date("M d", strtotime('monday this week'));
			$saturday_title = date("M d", strtotime('saturday this week'));

			$monday_db = date("Y-m-d", strtotime('monday this week'));
			$saturday_db = date("Y-m-d", strtotime('saturday this week'));

			// Get Student Names
			$sql = "SELECT UserID, Name FROM user WHERE Type = 'Student'";
			$result = $conn->query($sql);
			$students = array();
			if($result->num_rows > 0) {
				while($s = $result->fetch_assoc()){
			    	$students[$s['UserID']] = $s['Name'];
				}
			}

			// Get Sessions
			$sql = "SELECT StudentID, Date, Block FROM session WHERE TutorID = " . $id . " AND Date BETWEEN '" . $monday_db . "' AND '" . $saturday_db . "' ORDER BY Block, Date";
			$result = $conn->query($sql);
			$blocks = array(array("open", "open", "open", "open", "open", "open"),
							array("open", "open", "open", "open", "open", "open"),
							array("open", "open", "open", "open", "open", "open"),
							array("open", "open", "open", "open", "open", "open"),
							array("open", "open", "open", "open", "open", "open"),
							array("open", "open", "open", "open", "open", "open"),
							array("open", "open", "open", "open", "open", "open"),
							array("open", "open", "open", "open", "open", "open"),
							array("open", "open", "open", "open", "open", "open"),
							array("open", "open", "open", "open", "open", "open"),
							array("open", "open", "open", "open", "open", "open"),
							array("open", "open", "open", "open", "open", "open"));
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
                                <h3 class="subtitle"><span>&#9668</span> <?=$monday_title?> - <?=$saturday_title?> <span>&#9658</span></h3>
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
											<tr>
												<th>8:00 - 9:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>" . $blocks[0][0] . "</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>" . $blocks[0][1] . "</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>" . $blocks[0][2] . "</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>" . $blocks[0][3] . "</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>" . $blocks[0][4] . "</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>" . $blocks[0][5] . "</td>";} ?>
											</tr>
											<tr>
												<th>9:00 - 10:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>" . $blocks[1][0] . "</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>" . $blocks[1][1] . "</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>" . $blocks[1][2] . "</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>" . $blocks[1][3] . "</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>" . $blocks[1][4] . "</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>" . $blocks[1][5] . "</td>";} ?>
											</tr>
											<tr>
												<th>10:00 - 11:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>" . $blocks[2][0] . "</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>" . $blocks[2][1] . "</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>" . $blocks[2][2] . "</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>" . $blocks[2][3] . "</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>" . $blocks[2][4] . "</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>" . $blocks[2][5] . "</td>";} ?>
											</tr>
											<tr>
												<th>11:00 - 12:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>" . $blocks[3][0] . "</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>" . $blocks[3][1] . "</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>" . $blocks[3][2] . "</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>" . $blocks[3][3] . "</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>" . $blocks[3][4] . "</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>" . $blocks[3][5] . "</td>";} ?>
											</tr>
											<tr>
												<th>12:00 - 1:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>" . $blocks[4][0] . "</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>" . $blocks[4][1] . "</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>" . $blocks[4][2] . "</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>" . $blocks[4][3] . "</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>" . $blocks[4][4] . "</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>" . $blocks[4][5] . "</td>";} ?>
											</tr>
											<tr>
												<th>1:00 - 2:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>" . $blocks[5][0] . "</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>" . $blocks[5][1] . "</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>" . $blocks[5][2] . "</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>" . $blocks[5][3] . "</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>" . $blocks[5][4] . "</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>" . $blocks[5][5] . "</td>";} ?>
											</tr>
											<tr>
												<th>2:00 - 3:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>" . $blocks[6][0] . "</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>" . $blocks[6][1] . "</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>" . $blocks[6][2] . "</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>" . $blocks[6][3] . "</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>" . $blocks[6][4] . "</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>" . $blocks[6][5] . "</td>";} ?>
											</tr>
											<tr>
												<th>3:00 - 4:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>" . $blocks[7][0] . "</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>" . $blocks[7][1] . "</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>" . $blocks[7][2] . "</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>" . $blocks[7][3] . "</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>" . $blocks[7][4] . "</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>" . $blocks[7][5] . "</td>";} ?>
											</tr>
											<tr>
												<th>4:00 - 5:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>" . $blocks[8][0] . "</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>" . $blocks[8][1] . "</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>" . $blocks[8][2] . "</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>" . $blocks[8][3] . "</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>" . $blocks[8][4] . "</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>" . $blocks[8][5] . "</td>";} ?>
											</tr>
											<tr>
												<th>5:00 - 6:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>" . $blocks[9][0] . "</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>" . $blocks[9][1] . "</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>" . $blocks[9][2] . "</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>" . $blocks[9][3] . "</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>" . $blocks[9][4] . "</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>" . $blocks[9][5] . "</td>";} ?>
											</tr>
											<tr>
												<th>6:00 - 7:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>" . $blocks[10][0] . "</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>" . $blocks[10][1] . "</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>" . $blocks[10][2] . "</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>" . $blocks[10][3] . "</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>" . $blocks[10][4] . "</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>" . $blocks[10][5] . "</td>";} ?>
											</tr>
											<tr>
												<th>7:00 - 8:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>" . $blocks[11][0] . "</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>" . $blocks[11][1] . "</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>" . $blocks[11][2] . "</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>" . $blocks[11][3] . "</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>" . $blocks[11][4] . "</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>" . $blocks[11][5] . "</td>";} ?>
											</tr>
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