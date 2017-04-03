/**
 * Created by Cronos on 2/8/2017.
 */
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

$("#submitb").click(function() {
    var errorMessage = "";
    var fieldsMiss = "";
    if($("#email").val() == "") {
        fieldsMiss += "<p>Email</p>"
    }
     if($("#phone").val() == "") {
        fieldsMiss += "Telephone"
    }
     if($("#password").val() == "") {
        fieldsMiss += "<p>Password</p>"
    }
     if($("#cpassword").val() == "") {
        fieldsMiss += "<p>Confirmation password</p>"
    }
    if (fieldsMiss != "") {
        errorMessage += "<p> The following field(s) are missing:</p>" + fieldsMiss;
    }


    if(isEmail($("#email").val()) == false) {
        errorMessage += "<p>Your email adress is not valid.</p>";
    }
    if($.isNumeric($("#phone").val()) == false) {
        errorMessage +="<p>Your phone number is not numeric.</p>";
    }
    if($("#cpassword").val() != $("#password").val()) {
        errorMessage += "<p>Your passwords dont match.</p>"
    }
    //alert(errorMessage);

    if (errorMessage != "") {
        $("#errorMessage").html(errorMessage);
    } else {
        $(this).css("display", "none");
        $("#successMessage").fadeIn("slow");
        $("#errorMessage").hide();
    }
});


