<?php
//checks whether the user is logged in, if not redirects to login page
require_once '../includes/auth_check.php';
//connects to database
require_once '../config/database.php';

//gets current user's ID from the session
$user_id = $_SESSION['user_id'];
//gets the task ID from the URL
$task_id = $_GET['id'] ?? null;

//checks wether the task ID exists, if there's no task ID the page will not delete anything
if ($task_id) {
    //prepares the DELETE query
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    //execute or runs the delete query
    $stmt->execute([$task_id, $user_id]);
}

//redirets back to task list
header("Location: index.php");
exit;