<?php
	session_start();
	session_unset();

	if(!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['name'])|| !isset($_POST['confpassword']) || $_POST['password'] != $_POST['confpassword']){
		header("Location: loginform.php");
	}

	//include variables from config.req.php for database connectivity
	include_once '../config.req.php';

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	$sql = "INSERT INTO user (Name, Email, Password, Type) VALUES ('" . $_POST['name'] . "', '" . $_POST['email'] . "', '" . $_POST['password'] . "', 'Student')";
	$result = $conn->query($sql);

	$sql = "SELECT UserID, Name, Type from user WHERE Email = '". $_POST['email'] . "' AND Password = '" . $_POST['password'] . "'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo $row['UserID'] . " " . $row['Name'] . " " . $row['Type'];

			$_SESSION['UserID'] = $row['UserID'];
			$_SESSION['Name'] = $row['Name'];
			$_SESSION['Type'] = $row['Type'];

			if ($_SESSION['Type'] == 'Tutor') {
				header("Location: ../tutordashboard.php?location=0");
			} else if ($_SESSION['Type']== 'Admin') {
				header("Location: ../admindashboard.php?location=0");
			} else if ($_SESSION['Type'] == 'Student') {
				header("Location: ../browsetutor.php");
			} else {
				echo "Error: Type not found";
			}
		}
	} else {
		echo "Incorrect email and/or password";
	}

	$conn->close();
?>