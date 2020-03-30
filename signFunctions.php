<?php
	include 'generalFunctions.php';

/*Function: Check if field username and password are empty
  Params: username
          password
  Return: 0 - either username or password is empty
          1 - ok*/
function isEmpty($username, $password) {
	if ($username != "" && $password != "") {
		return 1;
	}

	return 0;
}

/*Function: Check if password is proper length
  Params: password
  Return: 0 - password too short or too long
          1 - ok*/
function isPasswordValid($password) {
	if ( $password.length >= 2 || $password.length <= 255) {
		return 1;
	}

	return 0;
}

/*Function: Check if username is proper length
  Params: username
  Return: 0 - username too long
          1 - ok*/
function isUsernameValid($username) {
	if ( $username.length <= 255) {
			return 1;
	}

	return 0;
}

/*Function: Signing in user with given password and checking if password is matching one in database
  Params: username
          password
  Return: exception - throws exceptions if something goes wrong*/
function signin($username, $password){
	$connection = databaseConnection();
	$query = "SELECT password FROM USER where username=?";
	if (!$queryStmt = mysqli_prepare($connection, $query)) {
		mysqli_close($connection);
		throw new Exception("Error: Not able to prepare statement (Sign in)");
	}

	mysqli_stmt_bind_param($queryStmt, "s", $username);
	if(!mysqli_stmt_execute($queryStmt)){
		mysqli_close($connection);
		throw new Exception("Error: Not able to execute statement (Sign in)");
	}

	mysqli_stmt_bind_result($queryStmt, $hashed);
	mysqli_stmt_fetch($queryStmt);	
	if (!$matching = password_verify($password, $hashed)) {
		mysqli_stmt_close($queryStmt);
		mysqli_close($connection);
		throw new Exception("Error: Inccorect password");
	}

	mysqli_stmt_close($queryStmt);
	mysqli_close($connection);

}

?>