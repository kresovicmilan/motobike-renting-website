<?php
	include 'pageElements.php';
	include 'map.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<title>MotoBike Renting</title>
		<link href='css/homepageStyle.css?d=<?php echo time(); ?>' rel='stylesheet' type='text/css'>
		<link href='css/generalStyle.css?d=<?php echo time(); ?>' rel='stylesheet' type='text/css'>
		<script type='text/javascript' src='javascript/jquery-3.3.1.min.js'>
		</script>
		<script type='text/javascript' src='javascript/homepage.js?d=<?php echo time(); ?>'>
		</script>
	</head>
	<body>
	
	<div class='row'>
		<div class = 'side'>
  			<div class='navigation'>
  				<?php
  					$loggedin = navigation();
  				?>
  			</div>
  		</div>

  		<div class = "main">
  			<?php
  				displayErrorMessage();
  			?>

  			<h3>Choose point on the map and book!</h3>
  			
  			<div id = 'mapArea'>
				<div id = 'map'>

		  			<?php
		  				//Check if getting points from database was successful
						try {
							$statsArray = showPoints($loggedin);
						} catch (Exception $e) {
							$message = $e->getMessage();
							redirection("homepage.php?msg=".htmlentities($message));
						}
		  			?>

  				</div>

  				<div id = 'renting'>
					<div id = 'selectedPointStats'><b>Selected point</b></div>
					<?php
						showRentingForm($loggedin);
					?>
				</div>

  			</div>

  			<?php
  				showStats($statsArray[0] + $statsArray[1], $statsArray[0], $statsArray[1]);
  			?>

  		</div>
  	</div>

  	<div class="footer">
  		<h4>Distributed programming I</h4>
	</div>

	</body>
</html>