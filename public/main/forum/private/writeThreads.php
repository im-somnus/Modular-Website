
<?php

$category = $_GET['viewcategory'];

?>
    <div> 

<?php

    echo '<div class="post">';
    echo "<b>". displayCategoryTitle() ."</b>";
    echo '<br>Create new topic <br>';
    echo '
    <div class="postFormWrapper">';
    echo'<form id="registerForm" method="post" action="index.php?viewcategory='. $category .'">
            Subject:
            <input id="postTitle" type="text" name="title"><br>
            Post: <textarea class="post" name="post"></textarea><br>
            <input type="submit" name="postSubmit" value="Submit">
        </form>
    </div>';
?>
        </div>
<?php

        if(isset($_POST['postSubmit']))
        {
            echo "<meta http-equiv='refresh' content='0'>";
        }