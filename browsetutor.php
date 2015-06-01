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
			$sql = "SELECT UserID, Name, Image, ShortDescription, Subjects, AvailableMonday, AvailableTuesday, AvailableWednesday, AvailableThursday, AvailableFriday, AvailableSaturday FROM tutor";
			$result = $conn->query($sql);

			$conn->close();
		?>
	</head>

	<body>
		
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div>
					<ul class="nav navbar-nav">
						<li><a href="home.php">Home</a></li>
						<li><a href="#">Tutors</a></li>
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
			
				<h1 class="title">Tutors</h1>

				<?php
					if ($result->num_rows > 0) {
			    		while($row = $result->fetch_assoc()) {

			    			echo "<div class=\"tutorOverview row\">
									<div class=\"col-md-12\">
										<div class=\"row\">
											<div class=\"col-md-3\">
												<img class=\"photoid\" src=\"images/". $row["Image"]."\" alt=\"photoid\" />
											</div>
											
											<div class=\"col-md-5\">
												<b>". $row['Name']."</b><br/>". $row["ShortDescription"].
											"</div>
											
											<div class=\"col-md-4\">
												<b>Subjects :</b>".
												$row["Subjects"].
												"<br/><br/>
												<b>Availibility:</b><br/>".
												($row["AvailableMonday"] == 1 ? "Mon " : "").
												($row["AvailableTuesday"] == 1 ? "Tues " : "").
												($row["AvailableWednesday"] == 1 ? "Wed " : "").
												($row["AvailableThursday"] == 1 ? "Thurs " : "").
												($row["AvailableFriday"] == 1 ? "Fri " : "").
												($row["AvailableSaturday"] == 1 ? "Sat" : "")
											."</div>
										</div>
											  <a id=\"homeCreateUserLink\" href=\"tutordetail.php?id=". $row["UserID"]."&location=0\">details >></a>		  
									</div>
								</div>";
			    		}
					}
				?>			
			</div>
 
		</div>

	</body>

</html>