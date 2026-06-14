<?php

//imports app.php
require_once __DIR__ . '/../config/app.php';

//starts a php session if it hasn't been started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title = $page_title ?? 'StudyMate';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($page_title); ?> | StudyMate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/public/css/style.css">
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <!-- Website Name Logo -->
        <a class="navbar-brand fw-bold" href="<?php echo $base_url; ?>/index.php">
            StudyMate
        </a>

        <div class="ms-auto">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?php echo $base_url; ?>/dashboard.php" class="btn btn-light btn-sm">Dashboard</a>
                <a href="<?php echo $base_url; ?>/auth/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            <?php else: ?>
                <a href="<?php echo $base_url; ?>/auth/login.php" class="btn btn-light btn-sm">Login</a>
                <a href="<?php echo $base_url; ?>/auth/register.php" class="btn btn-outline-light btn-sm">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main class="container py-4">