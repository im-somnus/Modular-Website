<?php 
if ( isset($_SESSION['error']) )
{
    echo $_SESSION['error']. "<br>";
    unset($_SESSION['error']);  
}

if (isset($_SESSION['success']))
{
    echo $_SESSION['success'] . "<br>";
    unset($_SESSION['success']);
}
?>