<?php
//checks whether the user is logged in, if not redirects to login page
require_once '../includes/auth_check.php';
//connects to database
require_once '../config/database.php';

//gets logged in user's  ID from sesssion
$user_id = $_SESSION['user_id'];
//gets the task ID from the URL
$task_id = $_GET['id'] ?? null;

//checks if the task ID exists
if ($task_id) {
    //prepares the update query
    $stmt = $pdo->prepare("
        UPDATE tasks 
        SET status = 'Completed' 
        WHERE id = ? AND user_id = ?
    ");

    //execute or run the update query
    $stmt->execute([$task_id, $user_id]);
}

//redirects back to task list
header("Location: index.php");
exit;