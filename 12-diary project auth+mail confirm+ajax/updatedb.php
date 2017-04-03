<?php
    session_start();
    if(array_key_exists("content",$_POST)){
        $link = mysqli_connect("localhost", "id947762_root", "12345", "id947762_users");
        if(mysqli_connect_error()){
            die('Could not connect to the database');
        }
        $query = "UPDATE `users` SET `diary` = '".mysqli_real_escape_string($link, $_POST['content'])."' WHERE id = '".mysqli_real_escape_string($link, $_SESSION['id'])."' LIMIT 1 ";
        mysqli_query($link,$query);
    }

?>
