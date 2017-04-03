<?php

    $weather = "";
    $error = "";
    $success= "";
    if(isset($_GET['location'])){
        $urlContent=@file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".urlencode($_GET['location'])."&appid=2e79658987bf8e8f24c7bfd767cf7e35");
        $weatherArray=json_decode($urlContent, true);
        if($weatherArray['cod']==200){
            $weather .= $weatherArray['weather'][0]['description'].". ";

            function minmax($a, $b){
                if($a != $b){
                    return "(min: ".$a."&deg;C-max: ".$b."&deg;C)";
                }
            }
            $weather .= "The temperature outside is ".(intval($weatherArray['main']['temp'])-273)."&deg;C ".minmax((intval($weatherArray['main']['temp_min'])-273),(intval($weatherArray['main']['temp_max'])-273)).". ";

            $weather .= "The wind speed is ".$weatherArray['wind']['speed']."ms. ";

            $weather .= "The sun rises at ".date("H:i A",$weatherArray['sys']['sunrise'])." and sets at ".date("H:i A",$weatherArray['sys']['sunset']).". ";

            $success = '<div class="alert alert-info" role="alert" style="width:550px; margin:30px auto;">
            <h3 class="text-center"><strong>'.ucfirst($weatherArray['name']).'</strong></h3>
  <strong>Last update: '.date("F j, Y, g:i a", $weatherArray['dt']).' - Description: </strong>'.$weather.'</div>';
        }else{
            $error = '<div class="alert alert-danger" role="alert" style="width:550px; margin:30px auto;">'
.'The city <strong>'.$_GET["location"].'</strong> was not found. Please check again.'.'</div>';
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
            padding-top:18vh;
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
        #map {
            width:380px;
            height:270px;
            z-index:10;
            position:absolute !important;
            bottom:0 !important;
            right:0 !important;
        }
    </style>
</head>
<body>
    <div class="bg container-fluid" id="top-image">
        <h1>What is the weather like ?</h1>
        <form method="get" >
            <div class="form-group">
                <label for="location">Enter the name of the city:</label>
                <input type="text" class="form-control" id="location" name="location"  placeholder="Eg. London, Tokyo" value="<?php if(array_key_exists('location', $_GET)) { echo $_GET["location"];} ?>">
            </div>
            <button type="submit" class="btn btn-info" id="search">Submit</button>
        </form>
        <div id="results">
            <?php
            if($weather){
                echo $success;
            }else{
                echo $error;
            }
            ?>
        </div>
        <div id="lat"></div>
        <div id="lng"></div>
        <div id="map"></div>
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

    $(document).ready(function(){
        // event.preventDefault();
        $.ajax({
            url: "https://maps.googleapis.com/maps/api/geocode/json?address="+$(":input").val()+"&key=AIzaSyBC1gfxrwImMPO1ZloiigDdlEk8vmrhiPw",
            type: "GET",
            success: function(data){
                var coords =[];
                $.each(data["results"][0]["geometry"]["location"], function(key, value){
                    coords.push(value);
                })
                var lat = coords[0];
                var lng = coords[1];
                $("#lat").html(lat);
                $("#lng").html(lng);
                // alert($("#lat").html());
            }
        });
    })
    // alert($("#lat").html());
    //     function initMap() {
    //     var coordonates = {lat: -25.363, lng: 131.044};
    //     var map = new google.maps.Map(document.getElementById('map'), {
    //       zoom: 4,
    //       center: coordonates,
    //     });
    //   }
    //  get smarter




    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBC1gfxrwImMPO1ZloiigDdlEk8vmrhiPw&callback=initMap">
    </script>
</body>
</html>
