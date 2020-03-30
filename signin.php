<?php
	include 'pageElements.php';
	httpsRedirection();
	if(checkLogin()){
		redirection("homepage.php");
	}
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Signin</title>
        <link href="css/generalStyle.css?d=<?php echo time(); ?>" rel="stylesheet" type="text/css">
        <link href="css/registerStyle.css?d=<?php echo time(); ?>" rel="stylesheet" type="text/css">
    </head>

    <body>

        <div class="row">
            <div class = "side">
                <div class = "navigation">
                    <?php
                        $loggedin = navigation();
                    ?>
                </div>
            </div>

            <div class = "main">
                <?php
                displayErrorMessage();
                ?>

                <form method="POST" action="signinAction.php">
                  <div class="container">
                    <h1>Sign in</h1>
                    <hr>

                    <label for="username"><b>Email</b></label>
                    <input type="text" placeholder="Enter Username, e.g. xxx@xxx.xxx" name="username" maxlength='255' required>

                    <label for="password"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="password" maxlength='255' required>
                    <hr>
                    <button type="submit" class="registerbtn">Sign in</button>
                  </div>
                </form>
            </div>
        </div>

    <div class="footer">
        <h4>Distributed programming I</h4>
    </div>
    </body>

    </html>