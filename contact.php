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
				$url = "formHandling/logout.php";
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
						<li><a href="#">Contact Us</a></li> 
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
			
				<h1 class="title">Contact Us</h1>
				
				
				<div class="row">
					<div id="contactForm" class="col-sm-6">
					
						<h2>Contact form</h2>
						 <form role="form" action="formHandling/sendmail.php" method="post">
							<div class="form-group">
							  <label for="name">Name:</label>
							  <input name="contactname" type="text" class="form-control" id="contactname" placeholder="Enter name*" required>
							</div>
							<div class="form-group">
							  <label for="email">Email:</label>
							  <input name="contactemail" type="email" class="form-control" id="contactemail" placeholder="Enter email*" required>
							</div>
							<div class="form-group">
							  <label for="contactNumber">Contact Number:</label>
							  <input name="contacttelp" type="tel" class="form-control" id="contacttelp" placeholder="Contact number*" required>
							</div>
							<div class="form-group">
							  <label for="message">Message:</label>
							  <textarea name="contactmessage" class="form-control" id="contactmessage" placeholder="Message*" rows="5" required></textarea>
							</div>
							<button type="submit" class="btn btn-default">Send Message</button>
						 </form>
							  
						
					</div>
					<div class="col-sm-6">
						<p id="address">
							<b>Telephone:</b> +1 (408) 857-0075<br/>
							<b>Email:</b> kaykim@aplus.com <br />
							<br/>
						</p>
						
						<iframe width="100%" height="380px" frameborder="0" style="border:0"
src="https://www.google.com/maps/embed/v1/place?q=A%20Plus%20Student%20Books%2C%20Saratoga%20Avenue%2C%20San%20Jose%2C%20CA%2C%20United%20States&key=AIzaSyCayhOK2qlfGsNwPyQjytj07QpWqE6f3zM"></iframe>
					
					
						


							  
					</div>
				</div>
				
				
			</div>
 
		</div>

	</body>

</html>