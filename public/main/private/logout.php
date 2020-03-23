<?php
    session_start();
    include_once("functionLibrary.php");

    // We set the user status from online (1) to offline (0)
    $user = $_SESSION['login']['user'];
    setOfflineStatus($user);

    // Unset the session variables.
    unset($_SESSION['login']);
    unset($_SESSION["rank"]);
    session_destroy();
    
    // Redirect to the login page:
    header('location: ../../../index.php');
    exit();
?>