<?php
	session_start();

	$day = date("Y-m-d", strtotime($_POST['day']));

	//include variables from config.req.php for database connectivity
	include_once '../config.req.php';

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "";
	if($_POST['amount'] == 1) {
		$sql = "DELETE FROM session WHERE TutorID=" . $_POST['tutorID'] . " AND StudentID=" . $_SESSION['UserID'] . " AND Date='" . $day . "' AND Block=" . $_POST['block'];
	} else {
		$sql = "DELETE FROM session WHERE TutorID=" . $_POST['tutorID'] . " AND StudentID=" . $_SESSION['UserID'] . " AND Block=" . $_POST['block'];
	}
	echo $sql;
	$result = $conn->query($sql);

	header("Location: ../tutordetail.php?id=" . $_POST['tutorID'] . "&schedule=true&location=0");
?>