$(document).ready(function () {

    /*Function: Checks if email is in proper form
      Params: email - provided email from form
      Return: 0 - not in proper form
              1 - ok*/
    function validateEmail(email) 
    {
        var regex = /\S+@\S+\.\S+/;
        return regex.test(email);
    }

    /*Function: Checks if password is in proper form
      Params: password - provided password from form
      Return: 0 - not in proper form
              1 - ok*/
    function validatePassword(password) {
        var regex = /(?:[^`!@#$%^&*\-_=+'/.,]*[`!@#$%^&*\-_=+'/.,]){2}/;
        return regex.test(password);
    }

    /*Function: Checks if string is in proper range [2, 255]
      Params: str - provided email/password from form
      Return: 0 - not in proper range
              1 - ok*/
    function validateLength(str) {
        return str.length >= 2 && str.length <= 255;
    }

    /*Function: Checks if password and repeated password are matching
      Params: password          - provided password from form
              password_repeated - provided repeated password from form
      Return: 0 - not matching
              1 - ok*/
    function validateMatching(password, password_repeated) {
        return password == password_repeated;
    }

    /*Function: Enable register button if everything is correct, if not send error message and disable button*/
    function enableButton() {
        if(!validateEmail($("#email").val())) {
            $("#reportMessage").text("Error: Email address not valid");
            $("#reportMessage").css({
                    'background-color': '#ed5a64'
            });
            $("#registerbtn").attr("disabled", "disabled");
            return;
        } 
        
        if(!validateLength($("#email").val())) {
            $("#reportMessage").text("Error: Email address not proper length");
            $("#reportMessage").css({
                    'background-color': '#ed5a64'
            });
            $("#registerbtn").attr("disabled", "disabled");
            return;
        }

        if(!validatePassword($("#psw").val())) {
            $("#reportMessage").text("Error: Password not valid");
            $("#reportMessage").css({
                    'background-color': '#ed5a64'
            });
            $("#registerbtn").attr("disabled", "disabled");
            return;
        }

        if(!validateLength($("#psw").val())) {
            $("#reportMessage").text("Error: Password not proper length");
            $("#reportMessage").css({
                    'background-color': '#ed5a64'
            });
            $("#registerbtn").attr("disabled", "disabled");
            return;
        }

        if(!validateMatching($("#psw").val(), $("#psw_repeat").val())){
            $("#reportMessage").text("Error: Passwords not matching");
            $("#reportMessage").css({
                    'background-color': '#ed5a64'
            });
            $("#registerbtn").attr("disabled", "disabled");
            return;
        }

        $("#registerbtn").removeAttr("disabled");
        $("#reportMessage").text("");
        $("#reportMessage").css({
                    'background-color': '#ffffff'
            });
    }

    /*Action: Email field changed -> check if it is possible to enable register button*/
    $("#email").change(function () {
        $("#reportMessage").val("");
        enableButton();
    });

    /*Action: Password field changed -> check if it is possible to enable register button*/
    $("#psw").change(function () {
        $("#reportMessage").text("");
        enableButton();
    });

    /*Action: Repeated password field changed -> check if it is possible to enable register button*/
    $("#psw_repeat").change(function () {
        $("#reportMessage").text("");
        enableButton();
    });
});