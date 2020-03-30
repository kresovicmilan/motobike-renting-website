$(document).ready(function () {
    $previous = null;

    //Action: Clicked point on map -> select or deselect && display overall stats
    $(".point").click(function () {

        if ($previous == null) {
            $nameSelect = "";
        } else {
            $nameSelect = $previous.attr("pointIDName");
        }

        $current = $(this);
        if ($nameSelect == $current.attr("pointIDName")) {

            $($previous).css({
                    'border': '0px solid black'
            });

            $previous = null;
            $("#selectedPointStats").css({
                'display': 'none'
            });
            $("#formStyle").css({
                'display': 'none'
            });
        } else {
            $($current).css({
                'border': '2px solid black',
                'border-radius': '50%'
            });

            $($previous).css({
                    'border': '0px solid black'
            });

            $("#selectedPointStats").css({
                'display': 'block'
            });
            $("#formStyle").css({
                'display': 'block'
            });

            $("#selectedPointStats").html("<b>Selected point</b></br>Selected point ID: " + $(this).attr("pointIDName")
            + "</br> Bicycles: " + $(this).attr("pointNumBicycle")
            + "</br> Motobikes: " + $(this).attr("pointNumMotobike")
            );


            $("#bookBicycles").val(0);
            $("#bookMotobikes").val(0);
            $("#errorForm").text("*Choose at least one bicycle or motobike");

            $("#bookPoint").val($(this).attr("pointIDName"))
            $previous = $current;
        }

    });

    //Function: Check if number of bicycles or number of motobikes is not equal to 0
    function formNotZero() {
        if (($("#bookBicycles").val() == 0 && $("#bookMotobikes").val() == 0)) {
            $("#errorForm").text("*Choose at least one bicycle or motobike");
            return;

        } else {
            $("#bookButton").removeAttr("disabled");
            $("#errorForm").text("")
            return;
        }
    }

    //Action: Clicked ok -> submit form
    $("#bookButton").click(function () {
        $("#errorForm").text("");
        $("#rentingForm").submit();
    });

    //Action: Changing number of bicycles -> check if value is 0
    $("#bookBicycles").change(function () {
        $("#errorForm").text("")
        formNotZero();
    });

    //Action: Changing number of motobikes -> check if value is 0
    $("#bookMotobikes").change(function () {
        $("#errorForm").text("")
        formNotZero();
    });

});