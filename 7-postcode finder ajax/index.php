<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Postcode Finder</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <h1>Postcode Finder</h1>
      <div id="message">

      </div>
        <form>
          <div class="form-group">
            <label for="formGroupExampleInput">Enter the adderess:</label>
            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
          </div>
          <button type="submit" class="btn btn-primary" id="find">Submit</button>
        </form>
    </div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script type="text/javascript" src="jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <script type="text/javascript">
        $("#find").click(function(e) {
            $.ajax ({
                url:"https://maps.googleapis.com/maps/api/geocode/json?address="+ encodeURIComponent($("input").val())+"&key=AIzaSyBC1gfxrwImMPO1ZloiigDdlEk8vmrhiPw",
                type:"GET",
                success: function(data){
                    console.log(data);
                    if(data["status"] != "OK") {
                        $("#message").html('<div class="alert alert-warning" role="alert"><strong>Postcode Not Found!</strong> Please enter a valid postcode.</div>');
                    }
                    else {
                    $.each(data["results"][0]["address_components"], function(key, value){
                        if (value["types"][0] == "postal_code") {
                            $("#message").html('<div class="alert alert-success" role="alert"><strong>Postcode Found!</strong> The postcode is: '+value["long_name"]+'.</div>');
                            // alert(value["long_name"]);
                        }
                    })
                    }
                }
            });
            return false;
        })

        </script>
  </body>
</html>
