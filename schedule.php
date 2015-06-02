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

			if(isset($_POST['email']) || isset($_POST['password'])){	
				session_unset();

				//include variables from config.req.php for database connectivity
				include_once 'config.req.php';

				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);

				// Check connection
				if ($conn->connect_error) {
				    die("Connection failed: " . $conn->connect_error);
				} 
				$sql = "SELECT UserID, Name, Type from user WHERE Email = '". $_POST['email'] . "' AND Password = '" . $_POST['password'] . "'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$_SESSION['UserID'] = $row['UserID'];
						$_SESSION['Name'] = $row['Name'];
						$_SESSION['Type'] = $row['Type'];
					}
				} else {
					echo "Incorrect email and/or password";
				}

				$conn->close();
			}

			$name = "Profile";
			$profile = "loginform.php";
			if (isset($_SESSION['Name'])) {
				$name = $_SESSION['Name'];
				if($_SESSION['Type'] == 'Tutor') {
					$profile = "tutordashboard.php?location=0";
				} else if($_SESSION['Type'] == 'Admin') {
					$profile = "admindashboard.php?location=0";
				} else {
					$profile = "home.php";
				}
			}

			$log = "Login";
			$url = "login.php";
			if(isset($_SESSION['Name'])) {
				$log= "Logout";
				$url = "logout.php";
			}

			$tutorName = htmlspecialchars($_GET["name"]);
			$tutorID = htmlspecialchars($_GET["id"]);
			$day = htmlspecialchars($_GET["day"]);
			$block = htmlspecialchars($_GET["block"]);
			$time = "";
			switch ($block) {
			    case "1":
			        $time = "8:00 - 9:00";
			        break;
			    case "2":
			        $time = "9:00 - 10:00";
			        break;
			    case "3":
			        $time = "10:00 - 11:00";
			        break;
			    case "4":
			        $time = "11:00 - 12:00";
			        break;
			    case "5":
			        $time = "12:00 - 1:00";
			        break;
			    case "6":
			        $time = "1:00 - 2:00";
			        break;
			    case "7":
			        $time = "2:00 - 3:00";
			        break;
			    case "8":
			        $time = "3:00 - 4:00";
			        break;
			    case "9":
			        $time = "4:00 - 5:00";
			        break;
			    case "10":
			        $time = "5:00 - 6:00";
			        break;
			    case "11":
			        $time = "6:00 - 7:00";
			        break;
			    case "12":
			        $time = "7:00 - 8:00";
			        break;
			}
			$cell = htmlspecialchars($_GET["student"]);

			$login = "hidden";
			$schedule = "hidden";
			$cancel = "hidden";

			if (!isset($_SESSION['Name'])) {
				$login = "show";
			} else if ($cell === "open"){
				//include variables from config.req.php for database connectivity
				include_once 'config.req.php';

				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);

				// Check connection
				if ($conn->connect_error) {
				    die("Connection failed: " . $conn->connect_error);
				} 
				$sql = "SELECT Subjects from tutor WHERE UserID = " . $tutorID;
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$subjects = explode (", ", $row['Subjects']);
				}
				$conn->close();

				$schedule = "show";
			} else {
				$cancel = "show";
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
						<li><a href="<?=$profile?>"><span class="glyphicon glyphicon-user"></span> <?=$name?></a></li>
						<li><a href="<?=$url?>"><span class="glyphicon glyphicon-log-in"></span> <?=$log?></a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container-fluid vertical-center" id="content">

			<img id="logo" src="images/logo.png" alt="logo" class=".img-responsive" />
			
			<div class="container">
			
				<h1 class="title">&nbsp;</h1>
				
				
				<div class="row">
					
					<div id="homeLogin" class="col-md-8 col-md-offset-2 <?=$login?>">
						<h2>Login to Continue</h2>
						 <form role="form" action="schedule.php?name=<?=$tutorName?>&id=<?=$tutorID?>&day=<?=$day?>&block=<?=$block?>&student=<?=$cell?>" method="post">
							<div class="form-group">
							  <label for="email">Email:</label>
							  <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
							</div>
							<div class="form-group">
							  <label for="pwd">Password:</label>
							  <input type="password" name="password" class="form-control" id="pwd" placeholder="Enter password" required>
							</div>		
							<button type="submit" class="btn btn-default">Login</button>
						 </form>
							  <a id="homeCreateUserLink" href="newuser.php">Create new account</a>					
					</div>

					<div id="scheduleSession" class="col-md-8 col-md-offset-2 <?=$schedule?>">
						<h2 class="text-center">Schedule Session</h2>
						<h4 class="text-center"><?=$tutorName?></h2>
						<h4 class="text-center"><?=$day?></h4>
						<h4 class="text-center"><?=$time?></h4>
						 <form role="form" action="schedulesession.php" method="post">
							<div class="form-group">
							  <label for="subject">Subject:</label>
							    <select class="form-control" name="subject" required>
							    	<option value="">Choose Subject</option>
							    	<?php
							    		foreach ($subjects as $s) {
							    			echo "<option value='". $s . "'>" . $s . "</option>";
							    		}
							    	?>
								</select>
							</div>							
							<div class="form-inline form-group">
							  	<div class="radio">
									<label><input type="radio" name="amount" value="1" required>One Session</label>
								</div>
								<div class="radio">
									<label><input type="radio" name="amount" value="5" required>Five Sessions</label>
								</div>
								<div class="radio">
									<label><input type="radio" name="amount" value="10" required>Ten Sessions</label>
								</div>
							</div>
							<input type="hidden" name="tutorID" value="<?=$tutorID?>">
							<input type="hidden" name="day" value="<?=$day?>">
							<input type="hidden" name="block" value="<?=$block?>">
							<a href="tutordetail.php?id=<?=$tutorID?>&schedule=true" class="btn btn-default">Cancel</a>
							<button type="submit" class="btn btn-default">Schedule Session</button>
						 </form>					
					</div>

					<div id="cancelSession" class="col-md-8 col-md-offset-2 <?=$cancel?>">
						<h2 class="text-center">Cancel Session</h2>
						<h4 class="text-center"><?=$tutorName?></h4>
						<h4 class="text-center"><?=$day?></h4>
						<h4 class="text-center"><?=$time?></h4>
						 <form role="form" action="cancelsession.php" method="post">
							<div class="form-group">
							  <label for="reason">Reason:</label>
							    <select class="form-control" name="reason" required>
							    	<option value="">Choose Reason</option>
									<option value="Illness">Illness</option>
									<option value="School Event">School Event</option>
									<option value="No Longer Need Tutoring">No Longer Need Tutoring</option>
									<option value="Other">Other</option>
								</select>
							</div>
							<div class="form-inline form-group">
							  	<div class="radio">
									<label><input type="radio" name="amount" value="1" required>Just This Session</label>
								</div>
								<div class="radio">
									<label><input type="radio" name="amount" value="all" required>All Sessions</label>
								</div>
							</div>
							<input type="hidden" name="tutorID" value="<?=$tutorID?>">
							<input type="hidden" name="day" value="<?=$day?>">
							<input type="hidden" name="block" value="<?=$block?>">	
							<a href="tutordetail.php?id=<?=$tutorID?>&schedule=true" class="btn btn-default">Cancel</a>
							<button type="submit" class="btn btn-default">Cancel Session</button>
						 </form>				
					</div>
				</div>
				
				
			</div>
 
		</div>

	</body>

</html>