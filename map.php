<?php

/*Function: Displaying points
  Params: loggedin - showing if user is logged in*/
function showPoints($loggedin) {
	$arrayPoints = getPoints();
	$sumBicycles = 0;
	$sumMotobikes = 0;
	$len = count($arrayPoints);

	for($i = 0; $i < $len; $i++) {
		displayPoint($arrayPoints[$i]);
		$sumBicycles += $arrayPoints[$i][3];
		$sumMotobikes += $arrayPoints[$i][4];
	}

	$statsArray = array();
	$statsArray[0] = $sumBicycles;
	$statsArray[1] = $sumMotobikes;
	return $statsArray;
}

/*Function: Displaying statistics
  Params: sumMeans     -  sum of all transportation vehicles
          sumBicycles  -  sum of all bicycles
          sumMotobikes -  sum of all motobikes*/
function showStats($sumMeans, $sumBicycles, $sumMotobikes) {
	echo "<div id = 'overallStats'><p><b>Count of bicycle: </b>".htmlentities($sumBicycles)."
	</br>
	<b>Count of motobikes: </b>".htmlentities($sumMotobikes) . "
	</br>
	<b>Overall: </b>".htmlentities($sumMeans)."
	</p></div>";
}

/*Function: Displaying single point on map
  Params: point  -  array cointaning one row from location table in database*/
function displayPoint($point) {
	$sum = $point[3] + $point[4];
	if ($sum == 0) {
		$color = "red";
	} else if ($sum > 3) {
		$color = "green";
	} else {
		$color = "yellow";
	}

	echo "
	<div class = 'point' pointIDName =" .htmlentities($point[0])."
	pointNumBicycle =" .htmlentities($point[3]). " 
	pointNumMotobike =" .htmlentities($point[4])." 
	style='margin-top:" .htmlentities(400 - $point[2])."px;
	margin-left:" .htmlentities($point[1])."px;
	background:".htmlentities($color).";'></div>";
}

/*Function: Reading one row from location table from database
  Return: arrayPoints - array containing one row from location database*/
function getPoints() {
	$connection = databaseConnection();

	$arrayPoints = array();
	if($queryResult = mysqli_query($connection, "SELECT * FROM LOCATION")) {
		while ($row = mysqli_fetch_array($queryResult)) {
			$arrayPoints[ ]=$row;
    	}
    	mysqli_free_result($queryResult); 
	} else {
		throw new Exception("Error: Not able to get points from database");
	}

	mysqli_close($connection);
	return $arrayPoints;
}

/*Function: Displaying renting form
  Params: loggedin - showing if user is logged in*/
function showRentingForm($loggedin) {
	if($loggedin){
	echo'
	<div id = "formStyle">				
		<form id="rentingForm" method="POST" action="booking.php">
			<input required type="hidden" id="bookPoint" name="bookPoint">
			<div class = "rowForm">
				<div class="col-25">
					Booked bicycles: 
				</div>
				<div class="col-75">
					<input required type="number" id="bookBicycles" placeholder = "Enter number of bicycles" name="bookBicycles" min="0" step="1">
				</div>
			</div>
			<div class = "rowForm">
				<div class="col-25">
					Booked motobikes: 
				</div>
				<div class = "col-75">
					<input required type="number" id="bookMotobikes" name="bookMotobikes" placeholder = "Enter number of motobikes" min="0" step="1" >
				</div>
			</div>
			<div class = "rowForm">
				<div class="col-25">
					<p id="errorForm"></p>
				</div>
			</div>
			<div class = "rowForm">
				<input class="button" id="bookButton" type="button" value="OK" disabled>
			</div>
		</form>
	</div>';
	}

}