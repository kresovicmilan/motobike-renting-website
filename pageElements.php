<?php
	include 'generalFunctions.php';
	session_start();
	cookieEnabled();

	echo "<a href='homepage.php'><div class='header'>
				<h1><b>MotoBike Renting</b></h1>
				<h4>Milan Kresovic s266915 - Erasmus+ student</h4>
			</div></a>";

    /*Function: Check if user is logged in
      Return: false - not logged in
              true  - logged in*/
	function checkLogin() {
		if (isset($_SESSION['user'])) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/*Function: Sets navigation in respec to log info of the user
      Return: loggedin - sets global variable on true if the user is logged in*/
	function navigation() {
		global $loggedin;
		if (isset($_SESSION['user'])) {
			httpsRedirection();
			$user = $_SESSION['user'];
			$loggedin = TRUE;

			authenticationTime();

			echo "
				<a href='homepage.php'>Homepage</a>
				<a href='signout.php'>Sign out</a>
				<span id = 'loggedinAs'>User: <b>".htmlentities($user)."</b> </span>";
		} else {
			$loggedin = FALSE;
			echo "
					<a href='homepage.php'>Homepage</a>
					<a href='signin.php'>Sign in</a>
					<a href='register.php'>Register</a>
	  		";
	  	}

		return $loggedin;
	}

	/*Function: Displays error message*/
	function displayErrorMessage() {
		$reportMsg = "";
		$colorReport = "";
		if(isset($_GET['msg']) && (htmlentities($_GET['msg']) == $_GET['msg'])){
			$reportMsg = $_GET['msg'];
		}

		if(isset($_GET['success']) && $_GET['success']) {
			$colorReport = "#1abc9c";
		} else if (isset($_GET['msg'])){
			$colorReport = "#ed5a64";
		} else {
			$colorReport = "#ffffff";
		}

		echo "<div id='reportMessage' style = 'background-color:".htmlentities($colorReport).";color: white;padding: 16px; width: 500px;'>".htmlentities($reportMsg)."</div>";
	}
?>

<noscript>
  <style>html{display:none;}</style>
  <meta http-equiv="refresh" content="0.0;url=noCookiesOrJavascript.php">
</noscript>