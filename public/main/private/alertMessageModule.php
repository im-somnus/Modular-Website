<?php 

// If any alert needs to be displayed
if (isset($_SESSION['error']) || isset($_SESSION['success']))
{
    // Create the div to show it
    echo '<div id="alerts">';
    
    // Outputs the errors/successes and unset them (show it only once)
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

    echo "</div>";
}

?>