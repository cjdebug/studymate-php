<?php

// Start session and check if user is logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Checks if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit;
}

//Import database connection
require_once 'config/database.php';

//gets logged in user's ID from session
$user_id = $_SESSION['user_id'];

// Count total subjects

//prepares the SQL query
$stmt = $pdo->prepare("SELECT COUNT(*) AS total_subjects FROM subjects WHERE user_id = ?");
//execute or run the query
$stmt->execute([$user_id]);
//gets the result and stores the number inside
$subject_count = $stmt->fetch(PDO::FETCH_ASSOC)['total_subjects'];

// Count total tasks
$stmt = $pdo->prepare("SELECT COUNT(*) AS total_tasks FROM tasks WHERE user_id = ?");
$stmt->execute([$user_id]);
$total_tasks = $stmt->fetch(PDO::FETCH_ASSOC)['total_tasks'];

// Count pending tasks
$stmt = $pdo->prepare("SELECT COUNT(*) AS pending_tasks FROM tasks WHERE user_id = ? AND status = 'Pending'");
$stmt->execute([$user_id]);
$pending_tasks = $stmt->fetch(PDO::FETCH_ASSOC)['pending_tasks'];

// Count completed tasks
$stmt = $pdo->prepare("SELECT COUNT(*) AS completed_tasks FROM tasks WHERE user_id = ? AND status = 'Completed'");
$stmt->execute([$user_id]);
$completed_tasks = $stmt->fetch(PDO::FETCH_ASSOC)['completed_tasks'];

// Count high priority pending tasks
$stmt = $pdo->prepare("SELECT COUNT(*) AS high_priority_tasks FROM tasks WHERE user_id = ? AND priority = 'High' AND status = 'Pending'");
$stmt->execute([$user_id]);
$high_priority_tasks = $stmt->fetch(PDO::FETCH_ASSOC)['high_priority_tasks'];

// Get 5 pending tasks with deadlines
$stmt = $pdo->prepare("
    SELECT tasks.*, subjects.subject_name
    FROM tasks
    LEFT JOIN subjects ON tasks.subject_id = subjects.id
    WHERE tasks.user_id = ?
    AND tasks.status = 'Pending'
    AND tasks.deadline IS NOT NULL
    ORDER BY tasks.deadline ASC
    LIMIT 5
");
$stmt->execute([$user_id]);
$upcoming_tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = 'Dashboard';

//Imports header.php
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
                    This is your StudyMate dashboard. Here you can quickly view your subjects,
                    tasks, deadlines, and study progress.
                </p>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h5 class="fw-bold">Subjects</h5>
                                <p class="display-6 mb-0"><?php echo $subject_count; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h5 class="fw-bold">Total Tasks</h5>
                                <p class="display-6 mb-0"><?php echo $total_tasks; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h5 class="fw-bold">Pending Tasks</h5>
                                <p class="display-6 mb-0"><?php echo $pending_tasks; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h5 class="fw-bold">Completed Tasks</h5>
                                <p class="display-6 mb-0"><?php echo $completed_tasks; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h5 class="fw-bold">High Priority</h5>
                                <p class="display-6 mb-0"><?php echo $high_priority_tasks; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 mb-4">
                    <h4 class="fw-bold mb-3">Upcoming Deadlines</h4>

                    <?php if (empty($upcoming_tasks)): ?>
                        <div class="alert alert-info">
                            No upcoming deadlines found.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Task</th>
                                        <th>Subject</th>
                                        <th>Priority</th>
                                        <th>Deadline</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- loop through upcoming tasks -->
                                    <?php foreach ($upcoming_tasks as $task): ?>
                                        <tr>
                                            <!-- display task information -->
                                            <td><?php echo htmlspecialchars($task['title']); ?></td>
                                            <td><?php echo htmlspecialchars($task['subject_name'] ?? 'No subject'); ?></td>
                                            <td><?php echo htmlspecialchars($task['priority']); ?></td>
                                            <td><?php echo htmlspecialchars($task['deadline']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
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