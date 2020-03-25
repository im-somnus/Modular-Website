<?php
rankCheck(2);
keepOnlineStatus($_SESSION['login']['user']);

    if (isset($_GET['edit']))
    {
?>
        <form action="" method="post" enctype="multipart/form-data">
            Select an image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
        </form>
<?php
        changeImage();
    }
?>
    <div>
        <p><b><?php echo $user ?></b></p>  
        <p>Points: <b><?php echo checkPoints($user) ?></b></p>
        <p><?php echo "Posts: <b>". countPostsByUsername($user); ?></b></p>
        <p><a href="index.php?profile&edit">Change profile picture</a></p> 

        <div id="profilePicture">
            <img src="<?php echo checkPFPByUsername($user); ?>" width="30%"/>
        </div>
        <br><a href='public/main/private/logout.php'><button>Logout</button></a>
    </div>