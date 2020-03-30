<?php
	include 'pageElements.php';
    httpsRedirection();
    if($loggedin = checkLogin()){
        redirection("homepage.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script type="text/javascript" src="javascript/jquery-3.3.1.min.js">
    </script>
    <script type="text/javascript" src="javascript/register.js?d=<?php echo time(); ?>">
    </script>
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

                <form method="POST" action="registerAction.php">
                  <div class="container">
                    <h1>Register</h1>
                    <p>Please fill in this form to create an account.</p>
                    <hr>

                    <label for="email"><b>Email</b></label>
                    <input type="text" placeholder="Enter Email, e.g. xxx@xxx.xxx" name="email" id = "email" maxlength='255' required>

                    <label for="psw"><b>Password (at least 2 special characters)</b></label>
                    <input type="password" placeholder="Enter Password (w/ 2 special characters)" name="psw" id = "psw" maxlength='255' required>

                    <label for="psw_repeat"><b>Repeat Password</b></label>
                    <input type="password" placeholder="Repeat Password" name="psw_repeat" id = "psw_repeat" maxlength='255' required>
                    <hr>
                    <button type="submit" class="registerbtn" id = "registerbtn" disabled>Register</button>
                  </div>
                </form>
            </div>
        </div>

        <div class="footer">
            <h4>Distributed programming I</h4>
        </div>
</body>

</html>