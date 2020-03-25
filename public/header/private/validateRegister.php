<?php 
session_start();
include_once("../../../public/main/private/db_con.php");
include_once("../../../public/main/private/functionLibrary.php");

    $user = mysqli_real_escape_string($link, $_POST['user']);
    $pass = mysqli_real_escape_string($link, $_POST['pass']);

    // If we leave any field empty, send back to index (register requires user/password anyway)
    if (empty($_POST['user']) || empty($_POST['pass']))
    {
        header("location: ../../../index.php");
        exit();
    }
    // If the form had data in it, we validate it against the server 
    else
    {
        register($user, $pass);
    }
?>