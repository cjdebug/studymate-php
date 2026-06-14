<?php
//starts session if not already started, before destroying it php needs to access the current session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear all session variables
$_SESSION = [];

//destroy session
session_destroy();

//redirects user to login page after logging out
header('Location: login.php');
exit;