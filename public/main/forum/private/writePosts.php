<?php
/* 
    Module in charge of writing posts in the specified thread
*/
    $category = $_GET['viewcategory'];
    $topic = $_GET['viewtopic'];
?>
    <div> 
    <div id="postFormStyle">
<?php

    echo '<div class="post">';
    echo "<b>". displayCategoryTitle() ."</b>";
    echo '<br> Post a new message <br>';
    echo '<hr>';
    echo '
    <div class="postFormWrapper">
   
            <div class="postForm">
                <form id="registerForm" method="post" action="index.php?viewcategory='. $category .'&viewtopic='. $topic .'">
                    <textarea class="post" name="post"></textarea><br>
                    <input type="submit" name="postSubmit" value="Submit">
                </form>
            </div>
        </div>
        </div></div>';

        if(isset($_POST['postSubmit']))
        {
            echo "<meta http-equiv='refresh' content='0'>";
        }

?></div>
