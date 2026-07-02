<?php

//Imports app.php
require_once __DIR__ . '/../config/app.php';

//Starts a PHP session if it has not been started already
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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Website Name / Logo -->
        <a class="navbar-brand fw-bold" href="<?php echo $base_url; ?>/index.php">
            StudyMate
        </a>

        <!-- Mobile Menu Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->

        <!-- Navbar links wrapper -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <!-- Navbar list -->
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?php echo $base_url; ?>/dashboard.php">
                            Dashboard
                        </a>
                    </li>

                    <!-- Subject link -->
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?php echo $base_url; ?>/subjects/index.php">
                            Subjects
                        </a>
                    </li>

                    <!-- Task link -->
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?php echo $base_url; ?>/tasks/index.php">
                            Tasks
                        </a>
                    </li>

                    <!-- showing logged-in user name -->
                    <li class="nav-item">
                        <span class="navbar-text text-white small me-lg-2">
                            <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </span>
                    </li>

                    <!-- Logout link -->
                    <li class="nav-item">
                        <a href="<?php echo $base_url; ?>/auth/logout.php" class="btn btn-outline-light btn-sm">
                            Logout
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Login links -->
                    <li class="nav-item">
                        <a href="<?php echo $base_url; ?>/auth/login.php" class="btn btn-light btn-sm">
                            Login
                        </a>
                    </li>

                    <!-- Register link -->
                    <li class="nav-item">
                        <a href="<?php echo $base_url; ?>/auth/register.php" class="btn btn-outline-light btn-sm">
                            Register
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">