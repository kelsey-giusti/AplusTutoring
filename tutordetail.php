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

			$id = htmlspecialchars($_GET["id"]);
			$sql = "SELECT UserID, Name, Image, FullDescription, Subjects, AvailableMonday, AvailableTuesday, AvailableWednesday, AvailableThursday, AvailableFriday, AvailableSaturday FROM tutor WHERE UserID = " . $id;
			$result = $conn->query($sql);
			$row = null;
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
			}
			$conn->close();
		?>

		<!-- Get Dates for Schedule -->
		<?php
			$monday = date("D M d", strtotime('monday this week'));
			$tuesday = date("D M d", strtotime('tuesday this week'));
			$wednesday = date("D M d", strtotime('wednesday this week'));
			$thursday = date("D M d", strtotime('thursday this week'));
			$friday = date("D M d", strtotime('friday this week'));
			$saturday = date("D M d", strtotime('saturday this week'));

			$monday_title = date("M d", strtotime('monday this week'));
			$saturday_title = date("M d", strtotime('saturday this week'));
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
						<li><a href="<?=$profile?>"><span class="glyphicon glyphicon-user"></span> <?=$name?></a></li>
						<li><a href="<?=$url?>"><span class="glyphicon glyphicon-log-in"></span> <?=$log?></a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container-fluid vertical-center" id="content">

			<img id="logo" src="images/logo.png" alt="logo" class=".img-responsive" />

			<div class="container">
				<h1 class="title"><?=$row['Name']?></h1>
				<div class="right-tabs clearfix" >
				
                <ul class="nav nav-tabs" id="dashboard">
					<li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
                    <li><a href="#schedule" data-toggle="tab">Schedule</a></li>
                </ul>
				
                <div class="tab-content dashboard-tab">
				
					<div class="tab-pane active" id="profile">
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
				
                    <div class="tab-pane" id="schedule">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="subtitle"><span>&#9668</span> <?=$monday_title?> - <?=$saturday_title?> <span>&#9658</span></h3>
                                <div class="table-responsive">
									<table class="table table-striped table-bordered">
										<thead>
											<tr>
												<th></th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>" . $monday . "</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>" . $tuesday . "</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>" . $wednesday . "</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>" . $thursday . "</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>" . $friday . "</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>" . $saturday . "</td>";} ?>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th>8:00 - 9:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>Bob</td>";} ?>
											</tr>
											<tr>
												<th>9:00 - 10:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>Bob</td>";} ?>
											</tr>
											<tr>
												<th>10:00 - 11:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>Bob</td>";} ?>
											</tr>
											<tr>
												<th>11:00 - 12:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>Bob</td>";} ?>
											</tr>
											<tr>
												<th>12:00 - 1:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>Bob</td>";} ?>
											</tr>
											<tr>
												<th>1:00 - 2:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>Bob</td>";} ?>
											</tr>
											<tr>
												<th>2:00 - 3:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>Bob</td>";} ?>
											</tr>
											<tr>
												<th>3:00 - 4:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>Bob</td>";} ?>
											</tr>
											<tr>
												<th>4:00 - 5:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>Bob</td>";} ?>
											</tr>
											<tr>
												<th>5:00 - 6:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>Bob</td>";} ?>
											</tr>
											<tr>
												<th>6:00 - 7:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>Bob</td>";} ?>
											</tr>
											<tr>
												<th>7:00 - 8:00</th>
												<?php if ($row["AvailableMonday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableTuesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableWednesday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableThursday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableFriday"] == 1) {echo "<td>Bob</td>";} ?>
												<?php if ($row["AvailableSaturday"] == 1) {echo "<td>Bob</td>";} ?>
											</tr>
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