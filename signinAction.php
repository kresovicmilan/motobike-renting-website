<?php
	include 'signFunctions.php';
	
	// Checking if username field is set
	if (!isset($_POST['username'])) {
		redirection("signin.php?msg=Error: Input field (email) not set");
	}
	$username=strip_tags(htmlentities(($_POST['username'])));

	// Start session
	session_start();

	// Checking if password field is set
	$password = strip_tags(htmlentities(($_POST['password'])));
	if (!isset($password)) {
		redirection("signin.php?msg=Error: Input field (password) not set");
	}

	if (!isEmpty($username, $password)) {
		redirection("signin.php?msg=Error: Username or password field is empty");
	}

	if (!isUsernameValid($username)) {
		redirection("signin.php?msg=Error: Username not valid (too long)");
	}

	if (!isPasswordValid($password)) {
		redirection("signin.php?msg=Error: Password not valid (too short/too long)");
	}

	try {
		signin($username, $password);
		$_SESSION=array();
		$_SESSION['user']=$username;	
		$_SESSION['time']=time();
		redirection("homepage.php");
	} catch (Exception $e) {
		$message = $e->getMessage();
		redirection("signin.php?msg=".htmlentities($message));
	}
?>