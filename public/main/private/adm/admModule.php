<?php
session_start();
require("admFunctionLibrary.php");
require("../functionLibrary.php");
admRankCheck(1);


if (empty( $_POST))
{
   if ($_SESSION['rank'] < 1)
   {

    echo "<h2 class='h2Titles'> Admin Panel</h2>";
?>


        <div class="windowMain">
            <h2>Account Management</h2>
            <form action="" method="post"> 
                <input type="submit" value="Show Accounts" name="showAcc"><p>
                <input type="submit" value="Make Accounts" name="mkAcc"><p>
                <input type="submit" value="Modify Accounts" name="modAcc"><p>
                <input type="submit" value="Remove Accounts" name="rmAcc"><p>
            </form>
        </div>
<?php 
   }
   echo "<h2 class='h2Titles'> Mod Panel</h2>";
?>
        <div class="windowMain">
            <h2>Post Management</h2>
            <form action="" method="post"> 

                <input type="submit" value="Show/Remove Posts" name="showPost"><p>
            </form>
        </div>
        
<?php
}
else
    {

// users
        if (isset($_POST["mkAcc"]))
        {
            header("location: makeAccounts.php");
        }
        
        elseif ( isset($_POST["rmAcc"]))
        {
            header("location: removeAccounts.php");
        }

        elseif (isset($_POST["modAcc"]))
        {
            header("location: modifyAccounts.php");
        }
        
        elseif (isset($_POST["showAcc"]))
        {      
            header("location: showAccounts.php");
        }

// posts
        elseif ( isset($_POST["showPost"]))
        {
            header("location: removePosts.php");
        }

        echo '
        <a href="../../../../index.php"><button>Back to Index</button></a>';
    }
 



?>

