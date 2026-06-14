<?php

// Start session and check if user is logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//checks is the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit;
}

$page_title = 'Dashboard';
//imports header.php
require_once 'includes/header.php';

?>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-2">
                    Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
                </h2>

                <p class="text-muted mb-4">
                    This is your StudyMate dashboard. Soon, you will see your subjects,
                    tasks, deadlines, and progress here.
                </p>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h5 class="fw-bold">Subjects</h5>
                                <p class="display-6 mb-0">0</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h5 class="fw-bold">Pending Tasks</h5>
                                <p class="display-6 mb-0">0</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h5 class="fw-bold">Completed Tasks</h5>
                                <p class="display-6 mb-0">0</p>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="subjects/index.php" class="btn btn-primary">
                    Manage Subjects
                </a>

                <a href="tasks/index.php" class="btn btn-outline-primary">
                    Manage Tasks
                </a>
            </div>
        </div>
    </div>
</div>

<!-- imports footer.php -->
<?php require_once 'includes/footer.php'; ?>