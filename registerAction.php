<?php
	include 'registerFunctions.php';
	
	// Checking if email field is set
	if (!isset($_POST['email'])) {
		redirection("register.php?msg=Error: Input field (email) not set");
	}
	$email = strip_tags(htmlentities(($_POST['email'])));

	// Start session
	session_start();

	// Checking if password field is set
	$psw = strip_tags(htmlentities(($_POST['psw'])));
	if (!isset($psw)) {
		redirection("register.php?msg=Error: Input field (psw) not set");
	}

	// Checking if repeat password field is set
	$psw_repeat = strip_tags(htmlentities(($_POST['psw_repeat'])));
	if (!isset($psw_repeat)) {
		redirection("register.php?msg=Error: Input field (psw-repeat) not set");
	}

	// Checking if provided email is valid
	if (!isEmailCorrect($email)) {
		redirection("register.php?msg=Error: Email format not correct");
	}

	// Checking if provided password is valid
	if (!isPassCorrect($psw, $psw_repeat)) {
		redirection("register.php?msg=Error: Password format not correct/passwords aren't matching");
	}

	//Checking if username is already in database && adding username in database && redirecting registered user to homepage
	try {
		usernameInDB($email);
		addUsername($email, $psw);
		$_SESSION=array();
	    $_SESSION['user'] = $email;    
	    $_SESSION['time'] = time();
	    redirection("homepage.php"); 
	} catch (Exception $e) {
		$message = $e->getMessage();
		redirection("register.php?msg=".htmlentities($message));
	}

?>
