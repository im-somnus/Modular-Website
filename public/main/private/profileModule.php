<?php
rankCheck(2);
keepOnlineStatus($_SESSION['login']['user']);

echo "<h2 class='h2Titles'>" . $_SESSION['login']['user'] . "'s Profile</h2>";

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
        changeImage();
    }
    
?>
     <div id="profile">
         <div class="profileInfo">
            <p><b><?php echo $user ?></b></p>  
            <p>Points: <b><?php echo checkPoints($user) ?></b></p>
            <p><?php echo "Posts: <b>". countPostsByUsername($user); ?></b></p>
<?php
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
                <img alt="profile image" src="<?php echo checkPFPByUsername($user); ?>" width="30%"/>
            </div>
    </div>
    <br>
    <div id="logoutProfile">
          <a href='public/main/private/logout.php'><button>Logout</button></a>
    </div>