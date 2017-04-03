<?php
    require "twitteroauth\autoload.php";
    use Abraham\TwitterOAuth\TwitterOAuth;

    $ckey = "xdVZCl9C6tIbTJPVes1NV0P23";
    $csecret = "RjQl3BTh5OTnDnSiOC97tFFWI9U7u6PuF03Pn63v0vuZlYRNdE";
    $access_token = "838441529446449152-qrLOdo42I2pNHCjyb9NwaZdSe9QOAh9";
    $access_token_secret = "Kt5ZVoMjyFkGlFtHufJxwa1VJdb8enmqixImX27VSJ4oF";

    $connection = new TwitterOAuth($ckey, $csecret, $access_token, $access_token_secret);
    $content = $connection->get("account/verify_credentials");


    $statuses = $connection->get("statuses/home_timeline", ["count" => 25, "exclude_replies" => true]);
    foreach($statuses as $tweet) {
        if($tweet->favorite_count >=2){
            $status = $connection->get("statuses/oembed", ["id" => $tweet->id]);
            echo $status->html;
        }
    }


?>
