<?php 

/* 
    This module is in charge of validating the user data when login in the website.
*/

session_start();
include_once("../../../public/main/private/db_con.php");
include_once("../../../public/main/private/functionLibrary.php");

    $user = mysqli_real_escape_string($link, $_POST['user']);
    $pass = mysqli_real_escape_string($link, $_POST['pass']);

    // If we leave the form in blank, we wont be able to access.
    if (empty($_POST['user']) || empty($_POST['pass']))
    {
        header("location: ../../../index.php");
        exit();
    }
    // If the form had data in it, we validate it against the server 
    else
    {
        login($user, $pass);
    }
?>