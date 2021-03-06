<?php
    session_start();
    require("admFunctionLibrary.php");
    require("../functionLibrary.php");
    admRankCheck(1);
    
	if (isset($_SESSION['login']))
	{
		keepOnlineStatus($_SESSION['login']['user']);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
 	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Index</title>	
	<!-- BOOTSTRAP -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link href="admstyles.css" media="all" rel="stylesheet" type="text/css"/>	
</head>
	<body>
		<div class="container">
<div id="index"> 
<a href="../../../../index.php"><input type="button" value="Index"/></a> 

</div>
<?php

if (empty( $_POST))
{
   if ($_SESSION['rank'] < 1)
   {

    echo "<h2 class='h2Titles'> Admin Panel</h2>";
?>


        <div class="windowMain">
            <h2>Account Management</h2>
            <form action="" method="post"> 
                <input type="submit" value="Make Accounts" name="mkAcc"><p>
                <input type="submit" value="Show/Remove Accounts" name="showAcc"><p>
                <input type="submit" value="Modify Accounts" name="modAcc"><p>
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

        elseif (isset($_POST["modAcc"]))
        {
            header("location: modifyAccounts.php");
        }
        
        elseif (isset($_POST["showAcc"]))
        {      
            header("location: showRemoveAccounts.php");
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
			
    
		</div>
	</body>
</html>