<?php
rankCheck(2);
keepOnlineStatus($_SESSION['login']['user']);


if (!isset($_GET['viewtopic']))
{
    $category = $_GET['viewcategory'];
    
    // Here we submit our post into the db
    if (isset($_POST['postSubmit']))
    {
    
        $post = $_POST['post'];
        $title = $_POST['title'];

        if (!empty($post) && !empty($title))
        {
            if (!isset($_GET['post']))
            {
                insertForumThread($post, $title, $category);
            }
        }
    }

    displayThreads();
    echo "<br>";
    include('private/writeThreads.php');
}
else
{
               
                    
        // Here we submit our post into the db
        if (isset($_POST['postSubmit']))
        {
            $post = $_POST['post'];
                    $id = $_GET['viewtopic'];
        
            if (!empty($post) && !empty($id))
            {
                if (!isset($_GET['post']))
                {
                    insertForumPost($post, "" , $id);
                }
            }
        }

    
        displayPosts();
    

    echo "<br>";

    
        include('private/writePosts.php');  

     
}
?>


