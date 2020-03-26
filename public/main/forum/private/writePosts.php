<?php

    $category = $_GET['viewcategory'];
    $topic = $_GET['viewtopic'];
?>
    <div> 

<?php

    echo '<div class="post">';
    echo "<b>". displayCategoryTitle() ."</b>";
    echo '<br> Create new post <br>';
    echo '
    <div class="postFormWrapper">
   
            <div class="postForm">
                <form id registerForm method="post" action="index.php?viewcategory='. $category .'&viewtopic='. $topic .'">
                    Post: <br>
                    <textarea class="post" name="post"></textarea><br>
                    <input type="submit" name="postSubmit" value="Submit">
                </form>
            </div>
        </div>
</div>';

?>
    </div>