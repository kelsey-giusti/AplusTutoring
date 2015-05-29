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

		<title>A+ Tutoring</title>

		<?php
			session_start();

			if(!isset($_SESSION['UserID']) || !isset($_SESSION['Name']) || !isset($_SESSION['Type']) || $_SESSION['Type'] != 'Tutor') {
				echo "<script>
				alert('You must be logged in as a tutor to view this page');
				window.location.href='home.php';
				</script>";
			}

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

			// Get Tutor Data
			$id = $_SESSION['UserID'];
			$sql = "SELECT AvailableMonday, AvailableTuesday, AvailableWednesday, AvailableThursday, AvailableFriday, AvailableSaturday FROM tutor WHERE UserID = " . $id;
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
		
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div>
					<ul class="nav navbar-nav">
						<li><a href="home.php">Home</a></li>
						<li><a href="browsetutor.php">Tutors</a></li>
						<li><a href="contact.php">Contact Us</a></li> 
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="<?=$profile?>"><span class="glyphicon glyphicon-user"></span> <?=$_SESSION['Name']?></a></li>
						<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container-fluid vertical-center" id="content">

			<img id="logo" src="images/logo.png" alt="logo" class=".img-responsive" />

			<div class="container">
				<h1 class="title">Tutor Dashboard</h1>
				<div class="right-tabs clearfix" >
                <ul class="nav nav-tabs" id="dashboard">
                    <li class="active"><a href="#schedule" data-toggle="tab">Schedule</a></li>
                    <li><a href="#sessions" data-toggle="tab">Availability</a></li>
                    <li><a href="#timecard" data-toggle="tab">Timecard</a></li>
                </ul>
                <div class="tab-content dashboard-tab">
                    <div class="tab-pane active" id="schedule">
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
												<th>12:40 - 1:00</th>
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
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="sessions">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="subtitle">Availability</h3>
                                <div class="table-responsive">
									<table class="table table-striped table-bordered table-condensed">
										<thead>
											<tr>
												<th></th>
												<th>Monday</th>
												<th>Tuesday</th>
												<th>Wednesday</th>
												<th>Thursday</th>
												<th>Friday</th>
												<th>Saturday</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th>8:00 - 9:00</th>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
											</tr>
											<tr>
												<th>9:00 - 10:00</th>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
											</tr>
											<tr>
												<th>10:00 - 11:00</th>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
											</tr>
											<tr>
												<th>11:00 - 12:00</th>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
											</tr>
											<tr>
												<th>12:00 - 1:00</th>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
											</tr>
											<tr>
												<th>1:00 - 2:00</th>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
											</tr>
											<tr>
												<th>2:00 - 3:00</th>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
											</tr>
											<tr>
												<th>3:00 - 4:00</th>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
											</tr>
											<tr>
												<th>4:00 - 5:00</th>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
											</tr>
											<tr>
												<th>5:00 - 6:00</th>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
											</tr>
											<tr>
												<th>6:00 - 7:00</th>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
											</tr>
											<tr>
												<th>7:00 - 8:00</th>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
												<td><label><input type="checkbox"></label></td>
											</tr>
										</tbody>
									</table>
								</div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="timecard">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="subtitle">April 13 - April 25</h3>
                                <div class="row">
                                	<form id="timecard">
                                		<div class="col-md-10">
	                                		<div class="table-responsive">
		                  						<table class="table table-striped table-bordered table-condensed">
													<thead>
														<tr>
															<th>Date</th>
															<th>Hours</th>
															<th>Notes</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>Monday April 13</td>
															<td><label><input type="number" name="quantity" min="0" max="8" value="0"></label></td>
															<td><label><textarea rows="2" cols="40"></textarea></label></td>
														</tr>
														<tr>
															<td>Tuesday April 14</td>
															<td><label><input type="number" name="quantity" min="0" max="8" value="0"></label></td>
															<td><label><textarea rows="2" cols="40"></textarea></label></td>
														</tr>
														<tr>
															<td>Wednesday April 15</td>
															<td><label><input type="number" name="quantity" min="0" max="8" value="0"></label></td>
															<td><label><textarea rows="2" cols="40"></textarea></label></td>
														</tr>
														<tr>
															<td>Thursday April 16</td>
															<td><label><input type="number" name="quantity" min="0" max="8" value="0"></label></td>
															<td><label><textarea rows="2" cols="40"></textarea></label></td>
														</tr>
														<tr>
															<td>Friday April 17</td>
															<td><label><input type="number" name="quantity" min="0" max="8" value="0"></label></td>
															<td><label><textarea rows="2" cols="40"></textarea></label></td>
														</tr>
														<tr>
															<td>Saturday April 18</td>
															<td><label><input type="number" name="quantity" min="0" max="8" value="0"></label></td>
															<td><label><textarea rows="2" cols="40"></textarea></label></td>
														</tr>
																									<tr>
															<td>Monday April 20</td>
															<td><label><input type="number" name="quantity" min="0" max="8" value="0"></label></td>
															<td><label><textarea rows="2" cols="40"></textarea></label></td>
														</tr>
														<tr>
															<td>Tuesday April 21</td>
															<td><label><input type="number" name="quantity" min="0" max="8" value="0"></label></td>
															<td><label><textarea rows="2" cols="40"></textarea></label></td>
														</tr>
														<tr>
															<td>Wednesday April 22</td>
															<td><label><input type="number" name="quantity" min="0" max="8" value="0"></label></td>
															<td><label><textarea rows="2" cols="40"></textarea></label></td>
														</tr>
														<tr>
															<td>Thursday April 23</td>
															<td><label><input type="number" name="quantity" min="0" max="8" value="0"></label></td>
															<td><label><textarea rows="2" cols="40"></textarea></label></td>
														</tr>
														<tr>
															<td>Friday April 24</td>
															<td><label><input type="number" name="quantity" min="0" max="8" value="0"></label></td>
															<td><label><textarea rows="2" cols="40"></textarea></label></td>
														</tr>
														<tr>
															<td>Saturday April 25</td>
															<td><label><input type="number" name="quantity" min="0" max="8" value="0"></label></td>
															<td><label><textarea rows="2" cols="40"></textarea></label></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-md-2">
											<h2 class="subtitle-sm">Hours: 0</h2>
											<h2 class="subtitle-sm">$0.00</h2>
											<input type="submit" value="Submit" class="btn btn-default center-block" />
										</div>
									</form>
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