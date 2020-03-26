<?php
    // If we left the form in blank or credentials weren't validated, we won't be able to access home.php.
    if (empty($_SESSION['login']))
    { 
        // If we are not logged in and we havent clicked "register" button, show the login form
        if (!isset($_POST['Register']))
        {
?>
            <div class="rightCornerPanel">	
            <h3>Log in</h3>
                  <form action="public/header/private/validateLogin.php" method="post">
                    Username <input type="text" name="user" placeholder="Username" required>
                            <br>		
                        Password <input type="password" name="pass" placeholder="Password" required>
                            <br>
                        <input type="submit" name="Login" value="Log in"> 
                    </form>
                    <form method="post">
                        <input type="submit" name="Register" value="Register"> 
                    </form>
                </div>
<?php
        }   
        else
        {
            include("public/header/private/registerModule.php");
        }
    } 
   // If we are logged in, show the user panel.
   else
   {
        $user = $_SESSION['login']['user'];
        $userRank = $_SESSION['rank'];

?>
        <div id="userPanel">
            <div id="credentials">
                <p><?php echo $user ?></p>  
                <p><?php echo checkPoints($user).'$' ?></p>
                <p><?php echo "Posts: ". countPostsByUsername($user); ?></p>
                <p><a href="index.php?profile">Edit Profile</a></p> 
                <p><?php adminPanel($user, $userRank) ?></p>
            </div>
            <div id="profilePicturelogin">
                <img src="<?php echo checkPFPByUsername($user, $userRank); ?>" width="30%"/>
            </div>
            <br><a href='include/logout.php' id="logoutButton"><button>Logout</button></a>
            <div class="clearfix"></div>
         </div>
<?php
   }    
?>