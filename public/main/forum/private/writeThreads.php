<?php
/* 
     Module in charge of writing threads in the specified category
*/
$category = $_GET['viewcategory'];

?>
    <div> 

    <div id="postFormStyle">
<?php

    echo '<div class="post">';
    echo "<b>". displayCategoryTitle() ."</b>";
    echo '<br> Create a new thread <br>';
    echo '<hr>';
    echo '
    <div class="postFormWrapper">';
    echo'<form id="registerForm" method="post" action="index.php?viewcategory='. $category .'">
            Title: <br>
            <input id="postTitle" type="text" name="title"><br>
            Post: <br>
            <textarea class="post" name="post"  ></textarea><br>
            <input type="submit" name="postSubmit" value="Submit">
        </form>
    </div></div>';
    
?>
        </div>
<?php

        if(isset($_POST['postSubmit']))
        {
            echo "<meta http-equiv='refresh' content='0'>";
        }