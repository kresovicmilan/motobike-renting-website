  <?php

/*Function: Change databasa reservation and location table in respect to submitted booking request
  Params: user         -  user that has requested the booking
  		  bookPoint    -  point for which booking is made
  		  bookBicycles -  requested number of bicycles
  		  bookMotobikes-  requested number of motobikes
  Return: message  -  array of string, saying if the booking  was done correctly and if it was successful*/
function submitBooking($user, $bookPoint, $bookBicycles, $bookMotobikes){
	$executionMessage = array();
	$connection=databaseConnection();	
	try {
		// Don't allow autocommit
		mysqli_autocommit($connection, false);
		$reservedVehicles = array();
				
		$reservedVehicles = calculateReservations($connection, $bookPoint, $bookBicycles, $bookMotobikes);
		updateReservationAndLocationTable($connection, $user, $bookPoint, $reservedVehicles[0], $reservedVehicles[1], $reservedVehicles[2] - $reservedVehicles[0], $reservedVehicles[3] - $reservedVehicles[1]);
		
		// Commit
		mysqli_commit($connection);
	} catch (Exception $e) {
		// Rollback
		mysqli_rollback($connection);
		mysqli_close($connection);
		//Return exception message
		$executionMessage[0] = $e->getMessage();
		$executionMessage[1] = "0";
		return $executionMessage;
	}

	mysqli_close($connection); 
	$executionMessage[0] = "Successful: Booking done";
	$executionMessage[1] = "1";
	return $executionMessage;
}

/*Function: Updating the reservation table and location table, i. e. adding new row
  Params: connection      -  connection to database
          bookPoint       -  point on the map for booking
          bookBicycles    -  number of requested bicycles
          bookMotobikes   -  number of requested motobikes
	      updatedBicycles -  updated number of bicycles at respected point
	      updatedMotobikes-  updated number of motobikes at respected point
  Return: Exception - if not able to add new row in reservation table or location table*/
function updateReservationAndLocationTable($connection, $user, $bookPoint, $bookBicycles, $bookMotobikes, $updatedBicycles, $updatedMotobikes){
	//---------- Reservation table ----------------
	$query = "INSERT INTO RESERVATION(username, pointID, resBicycles, resMotobikes) VALUES (?,?,?,?)";
	if(!$queryStmt = mysqli_prepare($connection, $query)){
		throw new Exception("Error: Not able to prepare statement (Reservation table)");
	}
	//Binding parameter markers
	mysqli_stmt_bind_param($queryStmt, "ssii", $user, $bookPoint, $bookBicycles, $bookMotobikes);
	if(!mysqli_stmt_execute($queryStmt)){
		throw new Exception("Error: Not able to execute statement (Reservation table)");
	}

	//Store result and check if only one row was changed
	mysqli_stmt_store_result($queryStmt);
	if(mysqli_stmt_affected_rows($queryStmt) != 1){
		throw new Exception("Error: Affected rows not equal to 1 (Reservation table)");
	}

	mysqli_stmt_free_result($queryStmt);	
	mysqli_stmt_close($queryStmt);

	//------------ Location table -----------------
	$query = "UPDATE LOCATION SET numBicycle=?, numMotobike=? WHERE pointID=?";
	if(!$queryStmt = mysqli_prepare($connection, $query)){
		throw new Exception("Error: Not able to prepare statement (Location table)");
	}

	//Binding parameter markers
	mysqli_stmt_bind_param($queryStmt, "iis", $updatedBicycles, $updatedMotobikes, $bookPoint);
	if(!mysqli_stmt_execute($queryStmt)){
		throw new Exception("Error: Not able to execute statement (Location table)");
	}

	//Store result and check if only one row was changed
	mysqli_stmt_store_result($queryStmt);
	if(mysqli_stmt_affected_rows($queryStmt) != 1){
		throw new Exception("Error: Affected rows not equal to 1 (Location table)");
	}

	mysqli_stmt_free_result($queryStmt);	
	mysqli_stmt_close($queryStmt);
}

/*Function: Connects to database and finds if there is enough transportation vehicle. If not, try to recalculate in respet to given rules
  Params: connection    -  connection to database
          bookPoint     -  point on the map for booking
          bookBicycles  -  number of requested bicycles
          bookMotobikes -  number of requested motobikes
  Return: reserved - array, recalculated and checked value of requested bicycles and motobikes + numbers of bicycles and motobikes in database
          exception- if not possible to book or recalculate
*/
function calculateReservations($connection, $bookPoint, $bookBicycles, $bookMotobikes){
	$queryResult = array();

	$query = "SELECT numBicycle, numMotobike FROM LOCATION WHERE pointID=? FOR UPDATE";
	if(!$queryStmt = mysqli_prepare($connection, $query)){
		throw new Exception("Error: Not able to prepare statement");
	}
	//Binding parameter markers
	mysqli_stmt_bind_param($queryStmt, "s", $bookPoint);
	if(!mysqli_stmt_execute($queryStmt)){
		throw new Exception("Error: Not able to execute statement");
	}

	mysqli_stmt_store_result($queryStmt);
	mysqli_stmt_bind_result($queryStmt, $queryResult[0], $queryResult[1]);
	mysqli_stmt_fetch($queryStmt);
    mysqli_stmt_free_result($queryStmt);	
	mysqli_stmt_close($queryStmt);
	$noBicycles = $queryResult[0];
	$noMotobikes = $queryResult[1];

	$reserved = calculateTransportationRequest($noBicycles, $noMotobikes, $bookBicycles, $bookMotobikes);
	$reserved[2] = $queryResult[0];
	$reserved[3] = $queryResult[1];
	return $reserved;
}

/*Function: In respect of the rules given in the project, check if there is enough of vehicle, if not try to recalculate
  Params: bicyclesDB    -  number of bicycles in database
          motobikesDB   -  number of motobikes in database
          bookBicycles  -  number of requested bicycles
          bookMotobikes -  number of requested motobikes
  Return: reserved - recalculated and checked value of requested bicycles and motobikes
          exception- if not possible to book or recalculate*/
function calculateTransportationRequest($bicyclesDB, $motobikesDB, $bookBicycles, $bookMotobikes) {
	if ($bicyclesDB < $bookBicycles) {
		throw new Exception("Error: Not enough bicycles");
	}
	$bicycleDB -= $bookBicycles;

	$combined = $bicyclesDB + $motobikesDB;
	if($combined < $bookMotobikes) {
		throw new Exception("Error: Not enough motobikes, even with available bicycles");
	} else if ($motobikesDB < $bookMotobikes) {
		$bookBicycles = $bookBicycles + $bookMotobikes - $motobikesDB;
		$bookMotobikes = $motobikesDB;
	}

	$reserved = array();
	$reserved[0] = $bookBicycles;
	$reserved[1] = $bookMotobikes;

	return $reserved;
}


?>