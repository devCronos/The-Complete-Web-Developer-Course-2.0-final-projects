<?php
    $error="";
    $success="";
    $link = mysqli_connect("localhost", "id947762_root", "12345", "id947762_users");
    if(mysqli_connect_error()){
        die("Connection to the database could not be established. Please try again later.");
    }
    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
        $query = "SELECT `email`,`hash`,`active` FROM `users` WHERE email='".mysqli_real_escape_string($link,$_GET['email'])."' AND hash='".mysqli_real_escape_string($link,$_GET['hash'])."' AND active= '0' ";
        if(mysqli_num_rows(mysqli_query($link,$query))>0){
            $query = "UPDATE `users` SET active='1' WHERE email='".mysqli_real_escape_string($link,$_GET['email'])."' AND hash='".mysqli_real_escape_string($link,$_GET['hash'])."' AND active= '0' ";
            if(mysqli_query($link,$query)){
                $success="Your account has been activated. <a href='https://secretdiaryy.000webhostapp.com/'>You can now log in</a> ";
            }
        }else{
            $error = "Invalid url or account has already been activated. <a href='https://secretdiaryy.000webhostapp.com/'>Home page</a>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    </head>
    <body>
        <div class="infoBox">
            <?php if($error != ''){
                echo '<div class="alert alert-danger" role="alert">'.$error.'</div';
            }?>
        </div>
        <div class="infoBox">
            <?php if($success != ''){
                echo '<div class="alert alert-success" role="alert">'.$success.'</div';
            }?>
    </body>
</html>
