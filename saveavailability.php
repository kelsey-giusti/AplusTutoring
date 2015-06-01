<?php
	session_start();

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

	$sql = "DELETE FROM availability WHERE TutorID = " . $_POST['tutorID'];
	$result = $conn->query($sql);
	
	$sql = "INSERT INTO availability (TutorID, Day, Block) VALUES ";
	$i = 0;
	foreach ($_POST['available'] as $check) {
		list($block, $day) = explode(" ", $check);
		$sql .= "(" . $_POST['tutorID'] . "," . $day . "," . $block . ")";
		if($i < count($_POST['available'])-1) $sql .= ",";
		$i++;
	}
	$result = $conn->query($sql);

	$conn->close();

	header("Location: tutordashboard.php?id=" . $_POST['tutorID']  . "&location=" . $_POST['location']  . "&schedule=true");
?>