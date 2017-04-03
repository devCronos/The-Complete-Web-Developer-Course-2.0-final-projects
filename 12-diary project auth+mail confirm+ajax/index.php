<?php
    session_start();
    // print_r($_POST);
    $error = '';
    $success = '';
    $link = mysqli_connect("localhost", "id947762_root", "12345", "id947762_users");

    if(mysqli_connect_error()){
        die("Connection to the database could not be established. Please try again later.");
    }
    if(isset($_GET['logout'])){
        unset($_SESSION);
        setcookie("id","",time()-60*60);
        $_COOKIE['id']="";
    }
    if(isset($_POST['submit'])){
        if(!$_POST['email']){
            $error .= "<p>Please enter an email address <br>";
        }
        elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $error .= 'This is not a valid email address <br>';
        }
        if(!$_POST['password'] OR strlen($_POST['password'])<5){
            $error .= 'Your password must contain at least 6 characters. <br>';
        }
        if($error != ''){
            $error = "<p>The following error(s) occured: <br>".$error;
        }else{//SIGN UP
            if($_POST['formOnSign'] == 1){
                $query = "SELECT `id` FROM `users` WHERE `email`='".mysqli_real_escape_string($link, $_POST['email'])."' ";
                $result = mysqli_query($link, $query);
                if(mysqli_num_rows($result)>0){
                    $error = "This email address has already been registed";
                }else{
                    $hash = md5(rand(0,1000));
                    $query = "INSERT INTO `users` (email , password , hash) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."' , '".mysqli_real_escape_string($link, $_POST['password'])."' , '".mysqli_real_escape_string($link, $hash)."') ";
                    if(mysqli_query($link, $query)){
                        $success = "Your account has been registered. An confirmation email has been sent to ".$_POST['email'];
                        $query = "UPDATE `users` SET password='".md5(md5(mysqli_insert_id($link)).mysqli_real_escape_string($link, $_POST['password']))."'  WHERE `email`='".mysqli_real_escape_string($link, $_POST['email'])."' ";
                        mysqli_query($link,$query);
                        //mail
                        $to      = $_POST['email']; // Send email to our user
                        $subject = 'Signup | Verification'; // Give the email a subject
                        $message = '

                        Thanks for signing up!
                        Your account has been created, you can login after you have activated your account by following the url below.

                        ------------------------
                        Please click this link to activate your account:
                        https://secretdiaryy.000webhostapp.com/verify.php?email='.$_POST['email'].'&hash='.$hash.'';
                        $headers = 'From:noreply@secretdiaryy.com' . "\r\n"; // Set from headers
                        if(mail($to, $subject, $message, $headers)){
                        }
                    }else{
                        $error = "There was an error signing you up. Please try again later.";
                    }
                }
            }else{//LOG IN
                $query = "SELECT * FROM `users` WHERE `email`='".mysqli_real_escape_string($link, $_POST['email'])."' ";
                $result = mysqli_query($link,$query);
                if(!mysqli_num_rows($result)){
                    $error = "This email address has not been registed.";
                }else{
                    $row = mysqli_fetch_array($result);
                    $dbpw = $row['password'];
                    $dbid = $row['id'];
                    $hashed = md5(md5($dbid).$_POST['password']);
                    if($hashed == $dbpw){
                        $query = "SELECT `id` FROM `users` WHERE `email`='".mysqli_real_escape_string($link, $_POST['email'])."' AND active= '1' ";
                        $result = mysqli_query($link, $query);
                        if(mysqli_num_rows($result)>0){
                            $_SESSION['id'] = $dbid;
                            if(isset($_POST['stayLoggedIn'])){
                                setcookie("id", $dbid, time()+60*60*24*7);
                            }
                            header("Location: inside.php");
                        }else{
                            $error = "Your account has not yet been activated. Please check your email inbox and spam.";
                        }
                    }else{
                        $error = "Incorrect password.";
                    }
                }
            }
        }
    }
?>


<html>
<head>
    <meta charset="utf-8">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <style type="text/css">
        html {
            background: url("gr.jpg") no-repeat center center fixed;
            -moz-background-size: cover;
            -webkit-background-size: cover;
            -o-background-size: cover;
        }
        body {
            background: none;
            color: #FFF;
            font-weight: bold;
        }

        .container {
            width:35vw;
            text-align: center;
            margin-top: 33px;
        }
        h1,h5,nav {
            font-family: Lobster;
        }
        h1 {
            font-size: 5em;
        }
        #logInForm {
            display:none;
        }
        input, .btn {
            margin-top:13px;
        }
        .navbar {
            padding-top:2px;
            padding-bottom:2px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">Secret Diary</a>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">


    <button class="btn btn-outline-success btn-outline-info my-2 my-sm-0 ml-auto" type="submit" id="changer">Log In</button>

  </div>
</nav>

    <div class="container">
        <h1> Secrey diary</h1>
        <h5> Store your thoughts permanently and securely</h3>

        <div class="infoBox">
            <?php if($error != ''){
                echo '<div class="alert alert-danger" role="alert">'.$error.'</div';
            }?>
        </div>
        <div class="infoBox">
            <?php if($success != ''){
                echo '<div class="alert alert-info" role="alert">'.$success.'</div';
            }?>
        </div>
        <p> Interested? Sign up now!</p>
        <form method="post" id="signUpForm">
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="Your Email">
                <input class="form-control" type="password" name="password" placeholder="Password">
                <!-- <input class="checkbox" type="checkbox" name="stayLoggedIn" value=1> -->
                <input class="form-control" type="hidden" name="formOnSign" value=1>
                <button class="btn btn-info" type="submit" name="submit" value="Sign Up">Sign Up
            </div>
        </form>

        <form method="post" id="logInForm">
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="Your Email">
                <input class="form-control" type="password" name="password" placeholder="Password">
                <label>
                    <input class="checkbox" type="checkbox" name="stayLoggedIn" value=1>Stay logged in
                </label>
                <br>
                <input class="form-control" type="hidden" name="formOnSign" value=0>
                <button class="btn btn-success" type="submit" name="submit" value="Log In">Log In
            </div>
        </form>
    </div>

    <!-- jQuery first, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>

      <script type="text/javascript">

$("#changer").click(function()
{
    $(this).toggleClass("btn-outline-success");
  if ($(this).text() == "Log In")
  {
     $(this).text("Sign Up");
     $("#signUpForm").toggle();
     $("#logInForm").fadeToggle();
  }
  else
  {
     $(this).text("Log In");
     $("#signUpForm").fadeToggle();
     $("#logInForm").toggle();
  };
});


      </script>
</body>
</html>
