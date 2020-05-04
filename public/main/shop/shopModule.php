<?php
rankcheck(2);
/* 
    This module acts as an online store for the points earned in the game/donated.
    For now it will be hardcoded, in the future it will retrieve whatever is in the database
        and display it properly.
    You can buy skins, items in here, for now it will only sell a simple re-colour skin for the square game.    
*/

?>

        <div class="post">
            <div class="windowMain">
                <form method="post">
                    Price: 0  
                    <br> Buy:  <input type="checkbox" name="default" value="default"><br>
                    <img id="default" src="assets/images/shop/default.png" width="100px" height="100px"></image>
                    <input type="submit" value="Purchase" name="submit">
                </form>
            </div>
        </div>

        <div class="post">
            <div class="windowMain">
                <form method="post">
                    Price: 1500 
                    <br> Buy:  <input type="checkbox" name="Invader" value="Invader" ><br>
                    <img id="invader" src="assets/images/shop/invader.png" width="100px" height="100px"></image>
                    <input type="submit" value="Purchase" name="submit">
                </form>
                </div>
        </div>

<?php


if (isset($_POST['Invader']))
{
    
    $skin = $_POST['Invader'];
    $user = $_SESSION['login']['user'];
    
    buySkin($user, $skin);
    header("Refresh: 0");
}
 
 
if (isset($_POST['default']))
{
    
    $skin = $_POST['default'];
    $user = $_SESSION['login']['user'];
    

   buySkin($user, $skin);
   header("Refresh: 0"); 

}


