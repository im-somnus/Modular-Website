<?php
rankCheck(2);
keepOnlineStatus($_SESSION['login']['user']);

    if (isset($_GET['edit']) && $_GET['edit'] == 1)
    {
?>
       <div class="windowProfile">
        <form action="" method="post" enctype="multipart/form-data">
                Select an image to upload:
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" value="Upload Image" name="submit">
            </form>
       </div>
<?php
        changeImage();
    }
?>
     <div class="windowProfile">
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
        <div id="profileExtra">
            <img src="<?php echo checkPFPByUsername($user); ?>" width="30%"/>
        </div>
        <br><a href='public/main/private/logout.php'><button>Logout</button></a>
    </div>