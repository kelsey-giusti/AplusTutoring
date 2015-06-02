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
		<script src="clientScripting/helpers.js"></script>

		<!-- Schedule Control JavaScript -->
		<script src="clientScripting/admindashboard.js"></script>

		<title>A+ Tutoring</title>

		<?php
			session_start();

			// Get User Info
			if(!isset($_SESSION['UserID']) || !isset($_SESSION['Name']) || !isset($_SESSION['Type']) || $_SESSION['Type'] != 'Admin') {
				echo "<script>
				alert('You must be logged in as an administrator to view this page');
				window.location.href='home.php';
				</script>";
			}

			include_once "navbar/topbarlogic.php";
		?>

		<?php
			//include variables from config.req.php for database connectivity
			include_once 'config.req.php';

			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);

			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}

			// Get Tutors
			$sql = "SELECT UserID, Name FROM tutor";
			$result = $conn->query($sql);
			$tutors = array();
			if ($result->num_rows > 0) {
				while($t = $result->fetch_assoc()){
			    	$tutors[$t['UserID']] = $t['Name'];
				}
			}

			// Get Student Names
			$sql = "SELECT UserID, Name FROM user WHERE Type = 'Student'";
			$result = $conn->query($sql);
			$students = array();
			if($result->num_rows > 0) {
				while($s = $result->fetch_assoc()){
			    	$students[$s['UserID']] = $s['Name'];
				}
			}

			//Adjust for Sundays
			$monday = date("Y-m-d", strtotime('monday this week'));
			$date = date("Y-m-d", strtotime($_GET['location'] . ' days'));
			if(date('w', strtotime($date)) == 0) {
				if(!empty($_GET['back'])) {
					$location = $_GET['location'] - 1;
					header("Location: admindashboard.php?location=" . $location . "&schedule=true&back=true");
				} else {
					$location = $_GET['location'] + 1;
					header("Location: admindashboard.php?location=" . $location . "&schedule=true");
				}
			}

			//Deactivate back button if on monday of this week
			$back="";
			if($date <= $monday) {
				$back="inactive";
			}

			//Display current day
			$current = $date;
			$current = date("l, F d", strtotime($current));
			if(date('Ymd') == date('Ymd', strtotime($current))) {
				$current = "Today";
			}

			//Get Availability
			$sql = "SELECT Block, TutorID FROM availability WHERE Day = " . date('w', strtotime($date)) . " ORDER BY Block, TutorID";
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
					$checks[$a['Block']-1][($a['TutorID'] - 1001)] = "checked";
				}
			}

			//Get Sessions
			$sessions = array();
			for($i = 0; $i < 12; $i++) {
				$row = array();
				for($y = 0; $y < count($tutors); $y++) {
					if($checks[$i][$y] == 'checked') {
						array_push($row, "open");
					} else {
						array_push($row, "unavailable");
					}
				}
				array_push($sessions, $row);
			}

			$tutorIndex = 0;
			foreach ($tutors as $id => $name) {
				$sql = "SELECT StudentID, Block FROM session WHERE TutorID = " . $id . " AND Date='" . $date . "' ORDER BY Block";
				$result = $conn->query($sql);
				if($result->num_rows > 0) {
					while($session = $result->fetch_assoc()){
						$sessions[$session['Block']-1][$tutorIndex] = $students[$session['StudentID']];
					}
				}
				$tutorIndex++;
			}

			#set the name to appropiate name because $name used for other things here
			$name = $_SESSION['Name'];
		?>

	</head>

	<body>
		
		<!-- load top nav bar -->
		<?php include_once 'navbar/topbar.php' ?>

		<div class="container-fluid vertical-center" id="content">


			<div class="container">
				<h1 class="title">Admin Dashboard</h1>
				<div class="right-tabs clearfix" >
	                <ul class="nav nav-tabs" id="dashboard">
	                    <li class="active"><a href="#schedule" data-toggle="tab">Master Schedule</a></li>
	                </ul>
	                <div class="tab-content dashboard-tab">
	                    <div class="tab-pane active" id="schedule">
	                        <div class="row">
	                            <div class="col-md-12">
	                                <h3 class="subtitle"><span class="<?=$back?>" id="back">&#9668</span> <?=$current?> <span id="forward">&#9658</span></h3>
	                              	<div class="table-responsive">
									<table class="table table-striped table-bordered">
										<thead>
											<tr>
												<th></th>
												<?
													foreach ($tutors as $id => $name) {
    													echo "<th>$name</th>";
													}
												?>
											</tr>
										</thead>
										<tbody>
											<?
												$start = 8;
												$end = 9;
												for($i = 0; $i < 12; $i++) {
													echo "<tr>";

													echo "<th>" . $start . ":00 - " . $end . ":00" . "</th>";
													for($y = 0; $y < count($sessions[$i]); $y++) {
														echo "<td>" . $sessions[$i][$y] . "</td>";
													}
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
	                            </div>
	                        </div>
	                    </div>
	                </div>
                </div>
			</div>
 
		</div>

	</body>

</html>