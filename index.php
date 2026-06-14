<?php

$page_title = 'Home';
//imports header.php
require_once 'includes/header.php';

?>

<section class="hero-section">
    <div class="row align-items-center w-100">
        <div class="col-md-6">
            <h1 class="display-5 fw-bold mb-3">
                Organize your university work with StudyMate
            </h1>

            <p class="lead text-muted mb-4">
                StudyMate helps students manage subjects, assignments, exams,
                lab tests, viva preparation, and daily study tasks in one simple place.
            </p>

            <a href="<?php echo $base_url; ?>/auth/register.php" class="btn btn-primary btn-lg me-2">
                Get Started
            </a>

            <a href="<?php echo $base_url; ?>/auth/login.php" class="btn btn-outline-primary btn-lg">
                Login
            </a>
        </div>

        <div class="col-md-6 mt-4 mt-md-0">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">Main Features</h4>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Create subjects/modules</li>
                        <li class="list-group-item">Add study tasks and deadlines</li>
                        <li class="list-group-item">Set task priority</li>
                        <li class="list-group-item">Mark tasks as completed</li>
                        <li class="list-group-item">View dashboard summary</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- imports footer.php -->
<?php require_once 'includes/footer.php'; ?>