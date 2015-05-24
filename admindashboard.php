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

			if(!isset($_SESSION['UserID']) || !isset($_SESSION['Name']) || !isset($_SESSION['Type']) || $_SESSION['Type'] != 'Admin') {
				echo "<script>
				alert('You must be logged in as an administrator to view this page');
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
				<h1 class="title">Admin Dashboard</h1>
				<div class="right-tabs clearfix" >
	                <ul class="nav nav-tabs" id="dashboard">
	                    <li class="active"><a href="#schedule" data-toggle="tab">Master Schedule</a></li>
	                    <li><a href="#timecards" data-toggle="tab">Timecards</a></li>
	                </ul>
	                <div class="tab-content dashboard-tab">
	                    <div class="tab-pane active" id="schedule">
	                        <div class="row">
	                            <div class="col-md-12">
	                                <h3 class="subtitle"><span>&#9668</span> Today <span>&#9658</span></h3>
	                              	                                <div class="table-responsive">
									<table class="table table-striped table-bordered">
										<thead>
											<tr>
												<th></th>
												<th>Branka Johnson</th>
												<th>Kelsey Marshman</th>
												<th>Frank Thompson</th>
												<th>Bill Anderson</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th>2:00 - 3:00</th>
												<td>John</td>
												<td>John</td>
												<td>John</td>
												<td>John</td>
											</tr>
											<tr>
												<th>3:00 - 4:00</th>
												<td>John</td>
												<td>John</td>
												<td>John</td>
												<td>John</td>
											</tr>
											<tr>
												<th>4:00 - 5:00</th>
												<td>John</td>
												<td>John</td>
												<td>John</td>
												<td>John</td>
											</tr>
											<tr>
												<th>5:00 - 6:00</th>
												<td>John</td>
												<td>John</td>
												<td>John</td>
												<td>John</td>
											</tr>
											<tr>
												<th>6:00 - 7:00</th>
												<td>John</td>
												<td>John</td>
												<td>John</td>
												<td>John</td>
											</tr>
											<tr>
												<th>7:00 - 8:00</th>
												<td>John</td>
												<td>John</td>
												<td>John</td>
												<td>John</td>
											</tr>
										</tbody>
									</table>
								</div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="tab-pane" id="timecards">
	                        <div class="row">
	                            <div class="col-md-12">
	                                <h3 class="subtitle"><span>&#9668</span> April 13 - April 18 <span>&#9658</span> </h3>
	                                <div class="table-responsive">
                  						<table class="table table-striped table-bordered table-condensed">
											<thead>
												<tr>
													<th></th>
													<th>Hours</th>
													<th>Paycheck</th>
													<th>Submitted?</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Branka Johnson</td>
													<td>0</td>
													<td>$0.00</td>
													<td>no</td>
												</tr>
												<tr>
													<td>Kelsey Marshman</td>
													<td>0</td>
													<td>$0.00</td>
													<td>no</td>
												</tr>
												<tr>
												<td>Frank Thompson</td>
													<td>0</td>
													<td>$0.00</td>
													<td>no</td>
												</tr>
												<tr>
												<td>Bill Anderson</td>
													<td>0</td>
													<td>$0.00</td>
													<td>no</td>
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