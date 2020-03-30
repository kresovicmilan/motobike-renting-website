<?php
	include 'generalFunctions.php';

/*Function: Checking if username is already in database
  Params: username  -  provided email address used as username
  Return: exception -  if something went wrong*/
function usernameInDB($username){
	$connection = databaseConnection();	
	$query = "SELECT * FROM USER where username=?";
	if (!$queryStmt = mysqli_prepare($connection, $query)) {
		throw new Exception("Error: Not able to prepare statement (Checking username in database)");
	}
	
	mysqli_stmt_bind_param($queryStmt, "s", $username);
	if(!mysqli_stmt_execute($queryStmt)){
		throw new Exception("Error: Not able to execute statement (Checking username in database)");
	}

	mysqli_stmt_store_result($queryStmt);
	$numRows = mysqli_stmt_num_rows($queryStmt);
	if ($numRows != 0) {
		throw new Exception("Error: Username already in database");
	}

	mysqli_stmt_free_result($queryStmt);
	mysqli_stmt_close($queryStmt);
	mysqli_close($connection);
}

/*Function: Adding username in database
  Params: username - provided email as an username
          psw      - provided password
  Return: exception - if something went wrong*/
function addUsername($username, $psw){
	$connection = databaseConnection();
	$query = "INSERT USER(username, password) VALUES (?,?)";
	if(!$queryStmt = mysqli_prepare($connection, $query)){
		mysqli_close($connection);
		throw new Exception("Error: Not able to prepare statement (Adding username in database)");
	}

	if(!$hashed=password_hash($psw, PASSWORD_DEFAULT)){
		mysqli_close($connection);
		throw new Exception("Error: Not able to hash password (Adding username in database)");
	}
	
	mysqli_stmt_bind_param($queryStmt, "ss", $username, $hashed);
	if(!mysqli_stmt_execute($queryStmt)){
		mysqli_close($connection);
		throw new Exception("Error: Not able to execute statement (Adding username in database)");
	}
	
	mysqli_stmt_store_result($queryStmt);
	$numRows = mysqli_stmt_affected_rows($queryStmt);
	mysqli_stmt_free_result($queryStmt);
	mysqli_close($connection);
	if ($numRows == 0) {
		throw new Exception("Error: More than one affected row in database");
	}
}

/*Function: Checking if password is valid
  Params: psw         -  provided password in form
          psw_repeat  -  provided repeated password in form
  Return: 0 - password entry is ok
          1 - not ok*/
function isPassCorrect($psw, $psw_repeat){
	$regex = '/(?:[^`!@#$%^&*\-_=+\'\/.,]*[`!@#$%^&*\-_=+\'\/.,]){2}/';
	if (strlen($psw) >= 2 && strlen($psw_repeat) <= 255 && $psw == $psw_repeat) {
		if (preg_match($regex, $psw)) {
			return 1;
		}
	}
	return 0;
}

/*Function: Checking if email is valid
  Params: email - provided email in form
  Return: 0 - email entry is ok
          1 - not ok*/
function isEmailCorrect($email){
	if (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email)<=255) {
		//check if it's only string
		if (htmlentities($email)==$email) {
			return 1;
		}
	}

	return 0;
}

?>