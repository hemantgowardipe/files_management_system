<?php
session_start(); // Start the session

// Destroy all sessions
session_unset();
session_destroy();

// Redirect to login page
header("Location: index.php");
exit;
?>
