<?php
    // If session is set, redirect to index (so the user panel is shown)
    if (isset($_SESSION['login']['user']))  
    {
        header("location: ../../../index.php");
        exit();
    }
    else
    {
        // If we havent clicked "back", we'll show the form for register
        if (!isset($_POST['Back']))
        {
            // If we havent sent anything from the form, display the register form
            if (!isset($_POST['Submit']))
            {
?>
                <div class="rightCornerPanel">	
                    <h3>Create Account </h3>
                    <form action="public/header/private/validateRegister.php" method="post">
                            Username <input type="text" name="user" required><br>
                            Password <input type="password" name="pass" required><br>
                            <input type="submit" name="Submit" value="Submit">
                    </form>
                        <form method="post">
                            <input type="submit" name="Back" value="Back">
                        </form>
                </div>
<?php 
            }
        }

    }
?>