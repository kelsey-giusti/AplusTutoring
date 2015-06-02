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
			
				<h1 class="title">&nbsp;</h1>
				
				
				<div class="row">
					
					<div id="homeLogin" class="col-md-8 col-md-offset-2">
						<h2>Login</h2>
						 <form role="form" action="formHandling/login.php" method="post">
							<div class="form-group">
							  <label for="email">Email:</label>
							  <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
							</div>
							<div class="form-group">
							  <label for="pwd">Password:</label>
							  <input type="password" name="password" class="form-control" id="pwd" placeholder="Enter password">
							</div>		
							<button type="submit" class="btn btn-default">Login</button>
						 </form>
							  <a id="homeCreateUserLink" href="newuser.php">Create new account</a>					
					</div>
				</div>
				
				
			</div>
 
		</div>

	</body>

</html>