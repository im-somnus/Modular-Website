<?php
    // If we left the form in blank or credentials weren't validated, we won't be able to access home.php.
    if (empty($_SESSION['login']))
    { 
        // If we are not logged in and we havent clicked "register" button, show the login form
        if (!isset($_POST['Register']))
        {
?>
            <div class="loginModuleForm">	
                <h1>Login</h1>
                <div class="loginForm">
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
        <div id="loginModule">
            <div id="credentials">
                <p><b><?php echo $user ?></b></p>  
                <p>Points: <b><?php echo checkPoints($user) ?></b></p>
                <p><?php echo "Posts: <b>". countPostsByUsername($user); ?></b></p>
                <p><a href="index.php?profile">Edit Profile</a></p> 
                <p><?php adminPanel($user, $userRank) ?></p>
            </div>
            <div id="profilePicturelogin">
                <img src="<?php echo checkPFPByUsername($user, $userRank); ?>" width="30%"/>
            </div>
            <br><a href='public/main/private/logout.php' id="logoutButton">Logout</a>
         </div>
<?php
   }    
?>