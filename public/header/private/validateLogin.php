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
    
    // Check the data against the database
    $sql = "Select * from accounts where username='$user' and password=md5('$pass')";
    $result = mysqli_query($link, $sql);
   
    // Check if there are any results in the query
    $row = mysqli_fetch_assoc($result);
   
    // If there's a result, means login is succesful (pass and user are valid)
    if ($row)
    {
        // Store the user and rank data in the session to use it later on
        $_SESSION['login']['user'] = $_POST['user'];
        $_SESSION['rank'] = $row["rank"];

        // We set the status online and update the online timer to keep the online session up
        setOnlineStatus($_SESSION['login']['user']);
        keepOnlineStatus($_SESSION['login']['user']);

        // Redirect the user to the home page, since its valid.
        header("location: ../../../index.php");
        exit();
    }
    // If login is not valid, redirect to form.
    else
    {
        // We call logout.php to kill all session variables etc.
        header("location: ../../../public/main/private/logout.php"); 
    }
}