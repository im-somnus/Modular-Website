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


function showRemoveAccounts()
{
    require("../db_con.php");

// Check the data against the database
$sql = "Select * from accounts";
$result = mysqli_query($link, $sql);
mysqli_close($link);

$resultCheck = mysqli_num_rows($result);

    if (!isset($_POST['Delete']))
    {
?>
    <!-- Table displaying Accounts info-->
                <div>
                    <h2>Remove Accounts</h2>
                <a href="admModule.php"><input type="button" value="Back"/></a> <br> <br>
                <form action="" method=post>
                    <input id='boton' type='submit' value='Delete' name='Delete'><br><br>
                <table border='1' style="border-collapse: collapse;">
                    <tr>
                        <th>id</th>
                        <th>username</th>
                        <th>rank</th>
                        <th>points</th>
                        <th>pfpicture</th>
                        <th>userStatus</th>
                        <th>lastActivity</th>
                        <th>postCooldown</th>
                        <th>delete</th>
                    </tr>
<?php
    // We will keep iterating as long as theres data
    if ($resultCheck > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
            {
                $id = $row['id'];
                $username=$row["username"];
                $rank = $row['rank'];
                $points = $row['points'];
                $pfpicture = $row['pfpicture'];
                $userStatus = $row['userStatus'];
                if ($userStatus == 1)
                {
                    $userStatus = "Online";
                }
                else
                {
                    $userStatus = "..................";
                }

                $lastActivity = $row['lastActivity'];
                $postCooldown = $row['postCooldown'];
                echo "
                <TR>
                    <td>$id</td>
                    <TD>$username</TD>
                    <td>$rank</td>
                    <td>$points</td>
                    <td>$pfpicture</td>
                    <td>$userStatus</td>
                    <td>$lastActivity</td>
                    <td>$postCooldown</td>
                    <TD><INPUT type='checkbox' name='borrar[$id]'></TD>
                </TR>"; 
            }
    }
?>
                    </form>
                 </table>
                 </div>
<?php
    }
    else
    {
        if (!empty($_POST['borrar']))
        {
            $delete = $_POST["borrar"];

            // CREANDO LA CONSULTA DE BORRADO CON TODAS LAS EMPRESAS SELECCIONADAS
            foreach ($delete as $i => $value) 
            {
                    if ($value == "on")
                    {
                        $sql = "DELETE FROM accounts WHERE id='".$i."';";
    
                        // Verifying the query from the function verifyQuery
                        if (!executeQuery($sql))
                        {
                            $_SESSION['error'] = "The account cannot be removed, try again."; 
                            header("location: showRemoveAccounts.php");
                        }
                        
                            $_SESSION['success'] = "Account succesfully removed.<br>"; 
                            header("location: showRemoveAccounts.php");
                    }
            }
        }

        else
        {
            header("location: showRemoveAccounts.php");
        }
    }
}

function showAccounts()
{
    require("../db_con.php");

// Check the data against the database
$sql = "Select * from accounts";
$result = mysqli_query($link, $sql);
mysqli_close($link);

$resultCheck = mysqli_num_rows($result);

    if (!isset($_POST['Delete']))
    {
?>
    <!-- Table displaying Accounts info-->
                <div>
                  
                
                <table border='1' style="border-collapse: collapse;">
                    <tr>
                        <th>id</th>
                        <th>username</th>
                        <th>rank</th>
                        <th>points</th>
                        <th>pfpicture</th>
                        <th>userStatus</th>
                        <th>lastActivity</th>
                        <th>postCooldown</th>
                    </tr>
<?php
    // We will keep iterating as long as theres data
    if ($resultCheck > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
            {
                $id = $row['id'];
                $username=$row["username"];
                $rank = $row['rank'];
                $points = $row['points'];
                $pfpicture = $row['pfpicture'];
                $userStatus = $row['userStatus'];
                if ($userStatus == 1)
                {
                    $userStatus = "Online";
                }
                else
                {
                    $userStatus = "..................";
                }

                $lastActivity = $row['lastActivity'];
                $postCooldown = $row['postCooldown'];
                echo "
                <TR>
                    <td>$id</td>
                    <TD>$username</TD>
                    <td>$rank</td>
                    <td>$points</td>
                    <td>$pfpicture</td>
                    <td>$userStatus</td>
                    <td>$lastActivity</td>
                    <td>$postCooldown</td>
                </TR>"; 
            }
    }
?>
                 </table>
                 </div>
<?php
    }
    
}



function modifyAccounts()
{
    
    require("../db_con.php");
    if (empty($_POST['user']))
    {
    ?>
        <div>
            <h2>Modify Account</h2>
            <a href="admModule.php"><input type="button" value="Back"/></a> <br> <br>
            <form method="post">
            <input type="submit" value="Submit"><br><br>
            Account <input type="text" name="user" required/><br>
            Password <input type="text" name="pass" required/><br>
            Rank    <input type="text" name="rank" required/><br>
            Points <input type="text" name="points" required/><br><br>
            Old id <input type="number" name="id" required/><br>
            
            </form>
        </div>
    <?php
    showAccounts();
    }
    else
    {    
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $rank = $_POST['rank'];
        $points = $_POST['points'];
        $id = $_POST['id'];

        if ($rank > 2)
        {
            $_SESSION['error'] = "Rank cannot be higher than 2";
            header("location: modifyAccounts.php");
        }
        else
        {
            // Validate admin input
            validateAdminInput($user, $pass);

            $sql = "UPDATE accounts SET username='$user', password=password('$pass'),
                rank='$rank', points='$points' where id='$id';";

            // Verifying the query from the function verifyQuery
            if (!executeQuery($sql))
            {
                $_SESSION['error'] = "ERROR! The username cannot be modified.";
                header("location: modifyAccounts.php");
            }

            $_SESSION['success'] = "User information updated.";
            header("location: modifyAccounts.php");
        }
        
    }
}



?>