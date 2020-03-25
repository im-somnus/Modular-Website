<?php

if (isset($_GET['profile']))
include("./public/main/private/profileModule.php");
elseif (isset($_GET['forum']))
    include('forumModule.php');
elseif (isset($_GET['thread']))
    include('threadsModule.php');
elseif (isset($_GET['code']))
    include('cocModule.php');
elseif (isset($_GET['login']))
    echo "You must be logged in to view this content.";
elseif (isset($_GET['shop']))
    include('shopModule.php');
elseif (isset($_GET['points']))
    include('pointsModule.php');
elseif (isset($_GET['buy']))
    include('buyModule.php');
elseif (isset($_GET['news']))
    include('newsModule.php');
elseif (isset($_GET['updates']))
    include('updatesModule.php');
elseif (isset($_GET['overview']))
    include('overviewModule.php');
elseif (isset($_GET['videos']))
    include('videosModule.php');
elseif (isset($_GET['download']))
    include('downloadModule.php');
else
{   
    displayLastPosts();
    displayOnlineUsers();
}
?>