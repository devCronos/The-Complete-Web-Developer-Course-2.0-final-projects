<?php
    session_start();
    if(isset($_SESSION['id'])){
        $link = mysqli_connect("localhost", "id947762_root", "12345", "id947762_users");
        if(mysqli_connect_error()){
            die("Connection to the database could not be established. Please try again later.");
        }
        $query = "SELECT `diary` FROM `users` WHERE `id`= '".mysqli_real_escape_string($link, $_SESSION['id'])."'  ";
        $row = mysqli_fetch_array(mysqli_query($link, $query));
        $diary = $row['diary'];
    }else{
        header("Location: index.php");
    }
?>


<html>
<head>
    <meta charset="utf-8">
    <title>Diary</title>
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
        }
        #diary {
            height:90%;
            opacity: 0.95;
        }
        nav {
            font-family: Lobster;
        }
        .navbar {
            padding-top:2px;
            padding-bottom:2px;
        }
        textarea {
            resize: none;
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


    <a class="ml-auto" href='index.php?logout=1'><button class="btn btn-outline-primary btn-outline-info my-2 my-sm-0 ml-auto" type="submit" id="changer">Log Out</button></a>

    </div>
    </nav>
    <div class="container-fluid">
        <textarea class="form-control" id="diary"> <?php echo $diary; ?> </textarea>
    </div>

    <!-- jQuery first, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>

      <script type="text/javascript">

      $('#diary').bind('input propertychange', function() {
          $.ajax({
              method: "POST",
              url: "updatedb.php",
              data: { content: $("#diary").val()}
          });
      });

      </script>
</body>
</html>
