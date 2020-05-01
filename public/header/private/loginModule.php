<?php

/* 
    Module in charge of displaying 1 of 3 things, depending on the website status.
        If there's no account logged in it will display:
            - Login form to login in an account
            - Button to register an account
        If the register button is clicked:
            - It will load the register module to display the register form
        If theres an account logged in:
            - It will display the user panel with the name, points, posts, profile picture and logout button.
*/

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
                  Username <input type="text" name="user" required>
                            <br>		
                         Password <input type="password" name="pass" required>
                            <br>  <br>
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
                <p><b><?php echo '<span id="user">'.$user.'</span>'; ?></b></p>  
                <p>Points: <b><?php echo "<span id='points'>". returnPoints($user) ."</span>"; ?></b></p>
                <p><?php echo "Posts: <b>". countPostsByUsername($user) ?></b></p>
                <p><a href="index.php?profile">Edit Profile</a></p> 
                <p><?php adminPanel($user, $userRank) ?></p>
            </div>
            <div id="profilePicturelogin">
                <img alt="profile image" src="<?php echo checkPFPByUsername($user, $userRank); ?>" width="30%"/>
                <br>
                <a href='public/main/private/logout.php' id="logoutButtonLogin">Logout</a>
            
            </div>
         </div>
<?php
   }    
?>