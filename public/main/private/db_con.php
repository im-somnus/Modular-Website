<?php
    // Store db connection variables
    $hostName = "localhost";
    $usrName = "root";
    $dbPssword = "";
    $databaseName = "phplogin";

    // We make a connection to the db with those variables
    $link = mysqli_connect($hostName, $usrName, $dbPssword, $databaseName);

    // If connection gave an error / was false
    if (!$link)
    {
        header('location: ../../../index.php');
        // We store the error message to be printed on main module
        $_SESSION['error'] = 'Connect Error: ' . mysqli_connect_error();
    }
?>