<?php

// Validate the user input from login/register modules.
function validateAdminInput($user, $pass)
{
    $pattern = "/^[A-Za-z0-9][A-Za-z0-9_-]{3,21}$/";
    // Check if username meets the minimum requirements.
    if (!preg_match($pattern, $user))
    {
        $_SESSION['error'] = "Username does not meet the requirements, try again";

        header("location: makeAccounts.php");
        exit();
    }

    // Check if password meets the next pattern;
    $pattern = "/[@$%&A-Za-zçñ0-9_-]{3,20}$/";

    if (!preg_match($pattern, $pass))
    {
        $_SESSION['error'] = "Password does not meet the requirements, try again";

        header("location: makeAccounts.php");
        exit();
    }
    
}


// admin function to make an account
function makeAccounts()
{
    require("../db_con.php");
        
    if (!isset($_POST['user']))
    {
?>
    <div>
        <h2>Make Account</h2>
        <a href="admModule.php"><input type="button" value="Back"/></a> <br> <br>
        <form method="post">
        
        Account <input type="text" name="user" required/><br>
        Password <input type="text" name="pass" required/><br>
        Rank    <input type="text" name="rank" required/><br>
        Money    <input type="text" name="points" required/><br>
        <input type="submit" value="submit">
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
            header("location: makeAccounts.php");
        }
        else
        {
            // Validate admin input
            validateAdminInput($user, $pass);

            $sql = "INSERT INTO accounts (username, password, rank, points)
                            VALUES ('$user', md5('$pass'), '$rank', '$points');";

                // Verifying the query from the function executeQuery
                if (!executeQuery($sql))
                {
                    // Store the error in the session variable to display in main
                    $_SESSION['error'] = "ERROR! The username you entered is already in use.";

                    header("location: makeAccounts.php");
                }
            

                $_SESSION['success'] = "You have successfully created your account.";

                $path = "../../../../assets/images/users/profilePictures/";
                $mkdirPath = $path . $user . "/";
                if (!file_exists($mkdirPath))
                {
                    mkdir($mkdirPath);
                }
                header("location: makeAccounts.php");
        }
    }
}

?>