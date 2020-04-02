<?php
session_start();
include("../functionLibrary.php");
rankCheck(1);
?>

<a href="index.php"><button>Back to Index</button></a>
<?php

    if ( empty( $_POST) )
    {
       if ($_SESSION['rank'] < 1)
       {
?>


            <div>
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
?>
            <div>
                <h2>Post Management</h2>
                <form action="" method="post"> 

                    <input type="submit" value="Show/Remove Posts" name="showPost"><p>
                   <!--  <input type="submit" value="Make Posts" name="mkPost"><p>
                    <input type="submit" value="Modify Posts" name="modPost"><p> -->
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

        elseif ( isset($_POST["mkPost"]))
        {
            header("location: makePosts.php");
        }

        elseif (isset($_POST["modPost"]))
        {
            header("location: modifyPosts.php");
        }
        
    }
 

?>

