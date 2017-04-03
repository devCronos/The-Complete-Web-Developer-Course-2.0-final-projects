<?php
    // print_r ($_GET);
    $weather = "";
    $error = "";
    $city = "";

    // echo $link;
    $pageData = "";
        if(array_key_exists('location', $_GET)) {
            $city = str_replace(' ','',$_GET["location"]);
            $link = "http://www.weather-forecast.com/locations/".$city."/forecasts/latest";
            $file_headers = @get_headers($link);
            if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                $error = '<div class="alert alert-danger" role="alert" style="width:550px; margin:30px auto;">'
    .'The city <strong>'.$_GET["location"].'</strong> was not found. Please check again.'.'</div>';


            }
            else {
                $pageData = file_get_contents($link);
                $pageArray = explode ('3 Day Weather Forecast Summary:</b><span class="read-more-small"><span class="read-more-content"> <span class="phrase">', $pageData);
                $thisAndAfter = $pageArray[1];
                $zeroIsGood = explode('</span></span></span></p><div class="forecast-cont"><div class="units-cont"><a class="units metric active">&deg;C</a><a class="units imperial">', $thisAndAfter);
                $weather = $zeroIsGood[0];
                // echo $weather;
                // echo $success;
                $success = '<div class="alert alert-info" role="alert" style="width:550px; margin:30px auto;">
      <strong>3 Day Weather Forecast Summary: </strong>'.$weather.'</div>';

            }
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <style type="text/css">
        .container-fluid {
            text-align: center;
            background-image:url(gr.jpg);
            background-size: cover;
            padding-top:22vh;
            height: 100vh;
        }
        #location {
            width: 300px;
            margin:30px auto;
        }
        #top-image {
            background:url('gr.jpg') -25px -50px;
            position:fixed ;
            top:0;
            width:100%;
            z-index:0;
              height:100%;
              background-size: calc(100% + 50px);
        }
    </style>
</head>
<body>
    <div class="bg container-fluid" id="top-image">
        <h1>What is the weather like ?</h1>
        <form method="get">
            <div class="form-group">
                <label for="location">Enter the name of the city:</label>
                <input type="text" class="form-control" id="location" name="location" placeholder="Eg. London, Tokyo" value="<?php if(array_key_exists('location', $_GET)) { echo $_GET["location"];} ?>">
            </div>
            <button type="submit" class="btn btn-info">Submit</button>
        </form>
        <div id="results"><?php
        if($weather){
            echo $success;
        }else{
            echo $error;
        }
        ?> </div>
    </div>

    <script type="text/javascript" src="jquery-3.1.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
var movementStrength = 25;
var height = movementStrength / $(window).height();
var width = movementStrength / $(window).width();
$("#top-image").mousemove(function(e){
          var pageX = e.pageX - ($(window).width() / 2);
          var pageY = e.pageY - ($(window).height() / 2);
          var newvalueX = width * pageX * -1 - 25;
          var newvalueY = height * pageY * -1 - 50;
          $('#top-image').css("background-position", newvalueX+"px     "+newvalueY+"px");
});
});
    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>
