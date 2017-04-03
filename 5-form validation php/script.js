/**
 * Created by Cronos on 2/15/2017.
 */
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}
$("#submitb").click(function() {
    var errorMessage = "";
    var fieldsMiss = "";
    if ($("#email").val() == "") {
        fieldsMiss += "<p>Please fill the <strong>email</strong> field.</p>"
    }
    if ($("#subject").val() == "") {
        fieldsMiss += "<p>Please fill the <strong>subject</strong> field.</p>"
    }
    if ($("#content").val() == "") {
        fieldsMiss += "<p>Please fill the <strong>content</strong> field.</p>"
    }
    if (fieldsMiss != "") {
        errorMessage += "<p> The following field(s) are missing:</p>" + fieldsMiss;
    }
    if(isEmail($("#email").val()) == false) {
        errorMessage += "<p>Your email adress is not valid.</p>";
    }

    if (errorMessage != "") {
            $("#errorMessage").html(errorMessage);
            $("#errorMessage").fadeIn("fast");
        } else {
            $(this).css("display", "none");
            $("#successMessage").fadeIn("slow");
            $("#errorMessage").hide();
        }
});