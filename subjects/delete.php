<?php
//checks whether the user is logged in, if not redirects to login page
require_once '../includes/auth_check.php';
//connects to database
require_once '../config/database.php';

$user_id = $_SESSION['user_id'];
//gets the ID
$subject_id = $_GET['id'] ?? null;

//checks whether the ID exists, if there's no ID it sends user back to the subjects page
if (!$subject_id) {
    header("Location: index.php");
    exit;
}

//delete the subject only if id is selected subject ID and user_id is logged-in user's ID
$stmt = $pdo->prepare("DELETE FROM subjects WHERE id = ? AND user_id = ?");
$stmt->execute([$subject_id, $user_id]);

//after deleting sends user back to the subject list
header("Location: index.php");
exit;