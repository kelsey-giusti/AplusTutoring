<?php

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
			$logicon = "glyphicon-log-in";
			if(isset($_SESSION['Name'])) {
				$log= "Logout";
				$url = "formHandling/logout.php";
				$logicon = "glyphicon-log-out";
			}

?>