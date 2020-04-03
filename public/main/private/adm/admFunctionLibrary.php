<?php

// admin function to make an account
function makeAccounts()
{
    require("public/main/private/db_con.php");
    include_once("public/main/private/functionLibrary.php");
        
    if (empty($_POST['user']))
    {
    ?>
    <div>
        <h2>Make Account</h2>
        <a href="panelad.php"><input type="button" value="Back"/></a> <br> <br>
        <form method="post">
        
        Account <input type="text" name="user" required/><br>
        Password <input type="text" name="pass" required/><br>
        Rank    <input type="text" name="rank" required/><br>
        Money    <input type="text" name="points" required/><br>
        <input type="submit" value="Submit">
        </form>
    </div>
    <?php
    }      
    else
    {    
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $rank = $_POST['rank'];
        $points = $_POST['points'];

        if ($rank > 2)
        {
            $_SESSION['error'] = "Rank cannot be higher than 2";
            header( "refresh: 1; url=makeAccounts.php" );
        }
        else
        {
            // Validate if that user input was valid before doing any queries.
            validateUserInput($user, $pass);
            
            $sql = "INSERT INTO accounts (username, password, rank, points)
                            VALUES ('$user', md5('$pass'), '$rank', '$points')";

                // Verifying the query from the function executeQuery
                if (!executeQuery($sql))
                {
                    // Store the error in the session variable to display in main
                    $_SESSION['error'] = "ERROR! The username you entered is already in use.";

                    header("location: ../../../index.php?admPan");
                    exit();
                }
            

                $_SESSION['success'] = "You have successfully created your account.";

                $path = "../../../assets/images/users/profilePictures/";
                $mkdirPath = $path . $user . "/";
                if (!file_exists($mkdirPath))
                {
                    mkdir($mkdirPath, 0777, true);
                }

                header("location: ../../../index.php");
        }
    }
}

?>