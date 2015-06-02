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

			include_once "navbar/topbarlogic.php";
		?>
	</head>

	<body>
		
		<!-- load top nav bar -->
		<?php include_once 'navbar/topbar.php' ?>

		<div class="container-fluid vertical-center" id="content">

			<img id="logo" src="images/logo.png" alt="logo" class=".img-responsive" />
			
			<div class="container">
			
				<h1 class="title">Contact Us</h1>
				
				
				<div class="row">
					<div id="contactForm" class="col-sm-6">
					
						<p>Submission Success!</p>
						 
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