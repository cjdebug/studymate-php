<?php
//starts session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//checks if the user is not logged in, if not redirects to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: /studymate/auth/login.php");
    exit;
}
?>