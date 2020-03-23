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
    else
    {
        $sql = "INSERT INTO accounts (username, password) 
                      VALUES ('$user', md5('$pass'))";
        mysqli_close($link);

        // Verifying the query from the function verifyQuery
        if (!verifyQuery($sql))
        {
            $_SESSION['error'] = "ERROR! The username you entered is already in use.";
            header("location: ../../../index.php");
            exit();
        }
        
        header("location: ../../../index.php");
    }
?>