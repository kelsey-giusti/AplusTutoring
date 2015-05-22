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
	</head>

	<body>
		
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div>
					<ul class="nav navbar-nav">
						<li><a href="#">Home</a></li>
						<li><a href="#">Tutors</a></li>
						<li><a href="#">Contact Us</a></li> 
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
						<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
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
						 <form role="form">
							<div class="form-group">
							  <label for="name">Name:</label>
							  <input type="text" class="form-control" id="name" placeholder="Enter name*">
							</div>
							<div class="form-group">
							  <label for="email">Email:</label>
							  <input type="email" class="form-control" id="email" placeholder="Enter email*">
							</div>
							<div class="form-group">
							  <label for="contactNumber">Contact Number:</label>
							  <input type="tel" class="form-control" id="contactNumber" placeholder="Contact number*">
							</div>
							<div class="form-group">
							  <label for="message">Message:</label>
							  <textarea class="form-control" id="message" placeholder="Message*" rows="5"></textarea>
							</div>
							<p id="formDesc">* required field</p>	
							<button id="sendButton" type="submit" class="btn btn-default">Send Message</button>
						 </form>
							  
						
					</div>
					<div class="col-sm-6">
					
						<h4 id="addressTitle">Address & Directions:</h4>
						<p id="address">
							Lorem IPSUM Contact<br/>
							1234 ABCD start<br/>
							CUPERTINO<br/>
							US<br/>
							Telephone: +1 XXX XXX-XXXX<br/>
							E-mail: main@aplustutor.com
						</p>
						
						<iframe width="100%" height="380px" frameborder="0" style="border:0"
src="https://www.google.com/maps/embed/v1/place?q=Santa+Clara+University,+El+Camino+Real,+Santa+Clara,+CA,+United+States&key=AIzaSyCayhOK2qlfGsNwPyQjytj07QpWqE6f3zM"></iframe>
					
					
						


							  
					</div>
				</div>
				
				
			</div>
 
		</div>

	</body>

</html>