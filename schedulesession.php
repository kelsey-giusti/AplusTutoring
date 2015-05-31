<?php
	session_start();

	$values = "";
	$day = date("Y-m-d", strtotime($_POST['day']));
	for($i = 0; $i < $_POST['amount']; $i++) {
		$values .= "(" . $_POST['tutorID'] . ", " . $_SESSION['UserID'] . ", '" . $day . "', " . $_POST['block'] . ", '" . $_POST['subject'] . "')";
		if($i < $_POST['amount']-1) $values .= ",";
		$day = date("Y-m-d", strtotime($day . "+7 days"));
	}

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
	$sql = "INSERT INTO session (TutorID, StudentID, Date, Block, Subject) VALUES " . $values;
	$result = $conn->query($sql);

	header("Location: tutordetail.php?id=" . $_POST['tutorID'] . "&schedule=true");
?>