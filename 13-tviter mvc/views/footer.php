<footer class="footer">
    <div class="container">
        <span class="text-muted">&copy; My website 2017</span>
    </div>
</footer>


<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalTitle">Log In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" id="loginAlert"></div>
                <form>
                    <input type="hidden" id="loginActive" name="loginActive" value="1">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" placeholder="Email address">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" id="password" placeholder="Password">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="loginToggle">Sign up</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="loginSignupButton" class="btn btn-primary">Log In</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $("#loginToggle").click(function () {
        if($("#loginActive").val() == "1"){
            $("#loginActive").val("0");
            $("#loginModalTitle").html("Sign Up");
            $("#loginSignupButton").html("Sign Up");
            $(this).html("Log In");
        }else
        {
            $("#loginActive").val("1");
            $("#loginModalTitle").html("Log In");
            $("#loginSignupButton").html("Log In");
            $(this).html("Sign Up");
        }
    });


    $("#loginSignupButton").click(function () {
        $.ajax({
            type: "POST",
            url: "actions.php?action=loginSignup",
            data: "email=" + $("#email").val() +  "&password=" + $("#password").val() + "&loginActive=" + $("#loginActive").val(),
            success:[ function (result) {
                if(result == "1") {
                    window.location.assign("http://127.0.0.1/projects/tviter%20mvc/")
                }else{
                    $("#loginAlert").html(result).show();
                }
            }]
        })
    });

    $(".toggleFollow").click(function () {
        var id = $(this).attr("data-userId");
//        alert(id);

        $.ajax({
            type: "POST",
            url: "actions.php?action=toggleFollow",
            data: "userId=" + id,
            success: function(result) {
               if(result == "1") {
                   $("a[data-userId='" +id+ "']").html("Follow");
               }else{
                   $("a[data-userId='" +id+ "']").html("Unollow");
               }
            }
        })
    });

    $("#postTweetButton").click(function () {
        $.ajax({
            type: "POST",
            url: "actions.php?action=postTweet",
            data: "tweetContent=" + $("#tweetContent").val(),
            success: function(result) {
                if(result == "1"){
                    $("#tweetSuccess").show();
                    $("#tweetFail").hide();
                }else if(result != ""){
                    $("#tweetFail").html(result).show();
                    $("#tweetSuccess").hide();
                }
            }
        })
    });



</script>

</body>
</html>