<?php

/* 
    Module in charge of the user's profile and changing their profile picture
*/

rankCheck(2);
keepOnlineStatus($_SESSION['login']['user']);

echo "<h2 class='h2Titles'>" . $_SESSION['login']['user'] . "'s Profile</h2>";

    // If we clicked on "change profile picture" (== 1), display the window to upload picture  form
    if (isset($_GET['edit']) && $_GET['edit'] == 1)
    {
?>
           <div class="uploadProfile">
           <form action="" method="post" enctype="multipart/form-data">
                Select an image to upload:
                <br><br>
                <div style="height:0px;overflow:hidden">
                <input type="file" id="fileToUpload" name="fileToUpload" />
                    </div>
                    <button type="button" onclick="chooseFile();">Choose file</button>
                    <input type="submit" value="Upload Image" name="submit">
            </form>
            </div>
            <script>
                function chooseFile()
                 {
                    document.getElementById("fileToUpload").click();
                }
            </script>

<?php
        // Call to the function in charge of changing the profile picture
        changeImage();
    }
    
?>
    <!-- We display the profile information window -->
    <div id="profile">
         <div class="profileInfo">
            <p><b><?php echo $user ?></b></p>  
            <p>Points: <b><?php echo returnPoints($user) ?></b></p>
            <p><?php echo "Posts: <b>". countPostsByUsername($user); ?></b></p>
<?php
            // Toggles the display/not display the "select an image to upload" window
            if (isset($_GET['edit']) && $_GET['edit'] == 1)
            {
?>              
                <p><a href="index.php?profile&edit=0">Change profile picture</a></p>
<?php
            }
            else
            {
?>
                <p><a href="index.php?profile&edit=1">Change profile picture</a></p>
<?php                
            }
?>
         </div>  
            <div id="profileInfo">
                <!-- Finds the picture of the user that is logged in -->
                <img alt="profile image" src="<?php echo checkPFPByUsername($user); ?>" width="30%"/>
            </div>
    </div>
    <br>
    <div id="logoutProfile">
        <!-- Logout button -->
        <a href='public/main/private/logout.php'><button>Logout</button></a>
    </div>