<?php
//checks whether the user is logged in, if not redirects to login page
require_once '../includes/auth_check.php';
//connects to database
require_once '../config/database.php';
//saves user id from session to variable
$user_id = $_SESSION['user_id'];

$status_filter = $_GET['status'] ?? '';
$priority_filter = $_GET['priority'] ?? '';

//sql query to fetch tasks for the logged-in user, with optional filters for status and priority
$query = "
    SELECT tasks.*, subjects.subject_name 
    FROM tasks 
    LEFT JOIN subjects ON tasks.subject_id = subjects.id 
    WHERE tasks.user_id = ?
";

//Array that stores values that will go to the ? in the sql query
$params = [$user_id];

//If the user selected a status filter, add it to the SQL query 
if (!empty($status_filter)) {
    //where task.user_id = ? AND tasks.status = ? will be the final query if the user selected a status filter
    $query .= " AND tasks.status = ?";
    //adds the status filter value to the params array
    $params[] = $status_filter;
}

if (!empty($priority_filter)) {
    //where task.user_id = ? AND tasks.status = ? AND tasks.priority = ? will be the final query if the user selected a priority filter
    $query .= " AND tasks.priority = ?";
    //adds the priority filter value to the params array
    $params[] = $priority_filter;
}

//task with the nearest deadline will appear first, and it 2 tasks have the same deadline the one that was created first will appear first
$query .= " ORDER BY tasks.deadline ASC, tasks.created_at DESC";

//prepares the sql query
$stmt = $pdo->prepare($query);
//run the query using the values inside the $params array
$stmt->execute($params);
//get all matching tasks and store inside $tasks array
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = "My Tasks";
//imports header.php
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>My Tasks</h2>
        <a href="add.php" class="btn btn-secondary">Add Task</a>
    </div>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <!-- keeps the selected option visible after filtering -->
                <option value="Pending" <?php echo $status_filter === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="Completed" <?php echo $status_filter === 'Completed' ? 'selected' : ''; ?>>Completed</option>
            </select>
        </div>

        <div class="col-md-4">
            <select name="priority" class="form-select">
                <option value="">All Priorities</option>
                <!-- keeps the selected option visible after filtering -->
                <option value="Low" <?php echo $priority_filter === 'Low' ? 'selected' : ''; ?>>Low</option>
                <option value="Medium" <?php echo $priority_filter === 'Medium' ? 'selected' : ''; ?>>Medium</option>
                <option value="High" <?php echo $priority_filter === 'High' ? 'selected' : ''; ?>>High</option>
            </select>
        </div>

        <div class="col-md-4">
            <!-- submits the form and applies selected filters -->
            <button type="submit" class="btn btn-outline-success">Filter</button>
            <!-- reset goes back to the default view -->
            <a href="index.php" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <!-- Display No tasks found message if there are no tasks -->
    <?php if (empty($tasks)): ?>
        <div class="alert alert-info">
            No tasks found.
        </div>

    <!-- Display tasks if there are any -->
    <?php else: ?>
        <div class="row">
            <?php foreach ($tasks as $task): ?>
                <div class="col-md-6 mb-3">
                    <div class="card h-100 <?php echo $task['status'] === 'Completed' ? 'border-success' : ''; ?>">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <h5 class="card-title">
                                    <?php echo htmlspecialchars($task['title']); ?>
                                </h5>

                                <!-- shows a badge for task status -->
                                <span class="badge bg-<?php echo $task['status'] === 'Completed' ? 'success' : 'warning'; ?>">
                                    <?php echo htmlspecialchars($task['status']); ?>
                                </span>
                            </div>

                            <p class="text-muted mb-1">
                                Subject:
                                <?php echo htmlspecialchars($task['subject_name'] ?? 'No subject'); ?>
                            </p>

                            <p class="mb-1">
                                Priority:
                                <strong><?php echo htmlspecialchars($task['priority']); ?></strong>
                            </p>

                            <p class="mb-1">
                                Deadline:
                                <!-- display the deadline if there is one for the task -->
                                <?php echo $task['deadline'] ? htmlspecialchars($task['deadline']) : 'No deadline'; ?>
                            </p>

                            <!-- if the task has a description, display it -->
                            <?php if (!empty($task['description'])): ?>
                                <p class="card-text mt-2">
                                    <?php echo htmlspecialchars($task['description']); ?>
                                </p>
                            <?php endif; ?>

                            <!-- this button appears only if the task is pending -->
                            <div class="mt-3">
                                <?php if ($task['status'] === 'Pending'): ?>
                                    <a href="complete.php?id=<?php echo $task['id']; ?>" class="btn btn-sm btn-success">
                                        Mark Completed
                                    </a>
                                <?php endif; ?>

                                <a href="edit.php?id=<?php echo $task['id']; ?>" class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <a href="delete.php?id=<?php echo $task['id']; ?>" 
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this task?');">
                                    Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- imports footer -->
<?php include '../includes/footer.php'; ?>