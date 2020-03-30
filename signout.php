<?php
	include 'signFunctions.php';
	session_start();
	
	// If user not logged in, go to homepage
	if(!isset($_SESSION['user'])){
		redirection("homepage.php");
	}
	
	authenticationTime();
	
	signout();
	redirection("homepage.php");	 
?>