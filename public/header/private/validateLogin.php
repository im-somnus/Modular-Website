<?php 
session_start();
include_once("../../../public/main/private/db_con.php");
include_once("../../../public/main/private/functionLibrary.php");


// If we leave the form in blank, we wont be able to access.
if (empty($_POST['user']) || empty($_POST['pass']))
{
    // So we redirect the user to the form.
    header("location: ../../../index.php");
    exit();

}

// If the form had data in it, we validate it against the server 
else
{
    $user = $_POST['user'];
    $pass =  $_POST['pass'];
    
    login($user, $pass);

}