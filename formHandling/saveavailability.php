<?php
	session_start();

	//include variables from config.req.php for database connectivity
	include_once '../config.req.php';

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	// Delete old availability data
	$sql = "DELETE FROM availability WHERE TutorID = " . $_POST['tutorID'];
	$result = $conn->query($sql);
	
	// Insert new availability data

	$availableMonday = 0;
	$availableTuesday = 0;
	$availableWednesday = 0;
	$availableThursday = 0;
	$availableFriday = 0;
	$availableSaturday = 0;

	$sql = "INSERT INTO availability (TutorID, Day, Block) VALUES ";
	$i = 0;
	foreach ($_POST['available'] as $check) {
		list($block, $day) = explode(" ", $check);
		switch ($day) {
			case 1:
				$availableMonday = true;
				break;
			case 2:
				$availableTuesday = true;
				break;
			case 3:
				$availableWednesday = true;
				break;
			case 4:
				$availableThursday = true;
				break;
			case 5:
				$availableFriday = true;
				break;
			case 6:
				$availableSaturday = true;
				break;
		}
		$sql .= "(" . $_POST['tutorID'] . "," . $day . "," . $block . ")";
		if($i < count($_POST['available'])-1) $sql .= ",";
		$i++;
	}
	$result = $conn->query($sql);

	//Update Day Availability
	$sql = "UPDATE tutor SET AvailableMonday=" . $availableMonday . ", AvailableTuesday=" . $availableTuesday . ", availableWednesday=" . $availableWednesday . ", availableThursday=" . $availableThursday . ", AvailableFriday=" . $availableFriday . ", AvailableSaturday=" . $availableSaturday . " WHERE UserID=" . $_POST['tutorID'];
	$result = $conn->query($sql);

	$conn->close();

	header("Location: ../tutordashboard.php?id=" . $_POST['tutorID']  . "&location=" . $_POST['location']  . "&schedule=true");
?>