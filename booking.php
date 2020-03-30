<?php
	include 'generalFunctions.php';	
	include 'bookingFunctions.php';
	include 'map.php';
	session_start();	
	// Check if user is loggedin
	if(!isset($_SESSION['user'])){
		redirection("homepage.php");
	}
	// Check if session is over
	authenticationTime();
		
	// Read parameters from form and check if they are set
	$bookPoint=strip_tags(strtoupper($_POST['bookPoint']));
	
	if (!isset($bookPoint)) {
		redirection("homepage.php?msg=Error: Input field (pointID) not set");
	}

	$bookBicycles=$_POST['bookBicycles'];
	if (!isset($bookBicycles)) {
		redirection("homepage.php?msg=Error: Input field (Booked bicycles) not set");
	} else if (is_nan($bookBicycles)) {
		redirection("homepage.php?msg=Error: Input of field (Booked bicycles) must be a number");
	}

	$bookMotobikes=$_POST['bookMotobikes'];
	if (!isset($bookMotobikes)) {
		redirection("homepage.php?msg=Error: Input field (Booked motobikes) not set");
	} else if (is_nan($bookMotobikes)) {
		redirection("homepage.php?msg=Error: Input of field (Booked motobikes) must be a number");
	}

	$user=$_SESSION['user'];
	$executionMessage = submitBooking($user, $bookPoint, $bookBicycles, $bookMotobikes);
	redirection("homepage.php?msg=".$executionMessage[0]."&success=".$executionMessage[1]);
?>