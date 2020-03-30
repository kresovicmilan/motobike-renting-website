<?php

/*Function: Checking if session has expired (Authetication)*/
function authenticationTime() {
	if (isset($_SESSION['time']) && (time() - $_SESSION['time'] > 2*60)) {
		signout();
	    // last request was more than 2 minutes ago
	    redirection('signin.php?msg=Session has expired');
	}
	$_SESSION['time'] = time(); // update time
}

/*Function: Checking if cookies are enabled by setting testing cookie, if not redirect*/
function cookieEnabled() {
	if (!isset($_GET['cookies'])) {
		setcookie('cookieTest', 1, time()+60*60);
		if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != ""){
			header('Location:'.$_SERVER['PHP_SELF'].'?cookies=true&'.$_SERVER['QUERY_STRING']);
		}else{
			header('Location:'.$_SERVER['PHP_SELF'].'?cookies=true');
		}
	} 

	if(count($_COOKIE) <= 0) {
	    header('Location: noCookiesOrJavascript.php');
	}
}

/*Function: Signing out user and setting cookie time to long passed*/
function signout(){
	if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_unset();     // unset $_SESSION variable for the run-time 
	session_destroy();   // destroy session data in storage
}

/*Function: If https not set, redirect*/
function httpsRedirection(){
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS']==='off'){
		$redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	    redirection($redirect);
	}	
}

/*Function: Shortcut for redirection to other pages*/
function redirection($location){
	header('Location: '.$location);
	exit();	
}

/*Function: Connect to database
  Return: connection - established connection*/
function databaseConnection() {
	$hostDB  = 'localhost';    
	$nameDB  = 's266915'; 
	$userDB  = 's266915';     
	$passwordDB  = 'erworcee';
	$connection = mysqli_connect($hostDB, $userDB, $passwordDB, $nameDB);
	if (!$connection) {
		die('Error in connection ('.mysqli_connect_errno().')'.mysqli_connect_error());
	}

	return $connection;
}

?>