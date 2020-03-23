<?php

/* ####################################### TESTING TOOLS ####################################### */

// function to dump all variables (test)
function dump($v)
{
    echo '<pre>';
        var_dump($v);
    echo '<pre>';
}

/* ####################################### QUERY/SQL FUNCTIONS ####################################### */

// Function to shorten the queries, sends 0 if the query failed, 1 if it worked.
function verifyQuery($query)
{
    require("db_con.php");  
    
    if ($result = mysqli_query($link, $query)) 
    { 
        mysqli_close($link);
        // Returns true if success Query
        return 1;
    }
    else
    {
        mysqli_close($link); 
        // Returns false if failed Query
        return 0;
    }
}

/* ####################################### USERS FUNCTIONS ####################################### */

// Set to 1 the user status (online)
function setOnlineStatus($user)
{
    require("db_con.php");

    $sql = "UPDATE accounts SET userStatus='1' where username='$user';";
    $result = mysqli_query($link, $sql);

    mysqli_close($link);
}

// Function to update lastActivity timestamp in the database using $_SESSION when loading pages.
function keepOnlineStatus($user)
{
    require("db_con.php");
    
    // Set default timezone
    date_default_timezone_set('Europe/Madrid');
    // Store custom date format in a variable
    $date = date('Y-m-d H:i:s');

    // Update user user last activity with current time
    $sql = "UPDATE accounts SET lastActivity='$date' where username='$user';";
    mysqli_query($link, $sql);

    // Function that sets online status to "online"
    setOnlineStatus($user);
}

// Set to 0 the user status (offline).
function setOfflineStatus($user)
{
    require("db_con.php");

    // update status to 0 (offline)
    $sql = "UPDATE accounts SET userStatus='0' where username='$user';";
    mysqli_query($link, $sql);

    mysqli_close($link);
}

// Function to register an account 
function register($user, $pass)
{
    require("db_con.php");

    $sql = "INSERT INTO accounts (username, password) 
                      VALUES ('$user', md5('$pass'))";
        mysqli_close($link);

        // Verifying the query from the function verifyQuery
        if (!verifyQuery($sql))
        {
            // Store the error in the session variable to display in main
            $_SESSION['error'] = "ERROR! The username you entered is already in use.";

            header("location: ../../../index.php");
            exit();
        }
       
        header("location: ../../../index.php");
        exit;
}

// Function that verifies user login information and logs in the database.
function login($user, $pass)
{
    require("db_con.php");
    
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
        $_SESSION['error'] = "Login error, try again.";
        // We call logout.php to kill all session variables etc.
        header("location: ../../../public/main/private/logout.php"); 
    }
}


// Function to logout the users, destroy all session variables etc.
function logout($user)
{
    // We set the user status from online (1) to offline (0)
    $user = $_SESSION['login']['user'];
    setOfflineStatus($user);

    // Unset the session variables.
    unset($_SESSION['login']['user']);
    unset($_SESSION['login']);
    unset($_SESSION["rank"]);
    session_destroy();
    
    // Redirect to the login page:
    header('Location: ../../../index.php');
    exit();
}


/*  ####################################### POST FUNCTIONS ####################################### */



/*  ####################################### THREAD FUNCTIONS ####################################### */




/*  ####################################### CATEGORIES FUNCTIONS ####################################### */










?>