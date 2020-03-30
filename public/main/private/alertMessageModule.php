<?php 
if ( isset($_SESSION['error']) )
{
    echo "<p style='color: Red';>" . $_SESSION['error']. "<br>";
    unset($_SESSION['error']); 
}

if (isset($_SESSION['success']))
{
    echo "<p style='color: Green';>" . $_SESSION['success'] . "<br>";
    unset($_SESSION['success']);
}
?>