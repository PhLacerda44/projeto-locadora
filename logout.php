<?php
session_start();
$_SESSION = array(); // Clear all session variables
session_destroy();     // Destroy the session data
header("Location: login.php"); // Redirect to the login page
exit(); // Terminate script execution
?>