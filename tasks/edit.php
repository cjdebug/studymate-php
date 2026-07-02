<?php
//checks whether the user is logged in, if not redirects to login page
require_once '../includes/auth_check.php';
//connects to database
require_once '../config/database.php';

//gets logged in user's ID from session
$user_id = $_SESSION['user_id'];
//gets task ID from URL
$task_id = $_GET['id'] ?? null;

//if there's no task ID, go back to the task list
if (!$task_id) {
    header("Location: index.php");
    exit;
}

$errors = [];

//prepares the SQL query
$stmt = $pdo->prepare("SELECT * FROM subjects WHERE user_id = ? ORDER BY subject_name ASC");
//runs the query
$stmt->execute([$user_id]);
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

//gets the task that user wants to edit
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$task_id, $user_id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

//redirect if task doesn't exist
if (!$task) {
    header("Location: index.php");
    exit;
}

//gets existing task data from the database
$title = $task['title'];
$description = $task['description'];
$subject_id = $task['subject_id'];
$deadline = $task['deadline'];
$priority = $task['priority'];
$status = $task['status'];

//checks if the form is submitted, runs only whebn the user clicks the "Update Task" button
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $subject_id = $_POST['subject_id'] ?? '';
    $deadline = $_POST['deadline'] ?? '';
    $priority = $_POST['priority'] ?? 'Medium';
    $status = $_POST['status'] ?? 'Pending';

    //validate task title
    if (empty($title)) {
        $errors[] = "Task title is required.";
    }

    //validate priority
    if (!in_array($priority, ['Low', 'Medium', 'High'])) {
        $errors[] = "Invalid priority selected.";
    }

    //validate status
    if (!in_array($status, ['Pending', 'Completed'])) {
        $errors[] = "Invalid status selected.";
    }

    //continue only if there are no errors
    if (empty($errors)) {
        $subject_value = !empty($subject_id) ? $subject_id : null;
        $deadline_value = !empty($deadline) ? $deadline : null;

        //prepares SQL command to update the task
        $stmt = $pdo->prepare("
            UPDATE tasks 
            SET subject_id = ?, title = ?, description = ?, deadline = ?, priority = ?, status = ?
            WHERE id = ? AND user_id = ?
        ");

        //execute update query
        $stmt->execute([
            $subject_value,
            $title,
            $description,
            $deadline_value,
            $priority,
            $status,
            $task_id,
            $user_id
        ]);

        header("Location: index.php");
        exit;
    }
}

$page_title = "Edit Task";
//imports header.php
include '../includes/header.php';
?>

<div class="container mt-4">
    <h2>Edit Task</h2>

    <!-- shows errors if there are any -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Task Title</label>
            <input type="text" 
                name="title" 
                class="form-control" 
                value="<?php echo htmlspecialchars($title); ?>" 
                required>
        </div>

        <!-- subject dropdown -->
        <div class="mb-3">
            <label class="form-label">Subject</label>
            <select name="subject_id" class="form-select">
                <option value="">No subject</option>

                <?php foreach ($subjects as $subject): ?>
                    <option value="<?php echo $subject['id']; ?>"
                        <?php echo $subject_id == $subject['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($subject['subject_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- date picker -->
        <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input type="date" 
                name="deadline" 
                class="form-control"
                value="<?php echo htmlspecialchars($deadline ?? ''); ?>">
        </div>

        <!-- priority dropdown, currect priority is automatically selected -->
        <div class="mb-3">
            <label class="form-label">Priority</label>
            <select name="priority" class="form-select">
                <option value="Low" <?php echo $priority === 'Low' ? 'selected' : ''; ?>>Low</option>
                <option value="Medium" <?php echo $priority === 'Medium' ? 'selected' : ''; ?>>Medium</option>
                <option value="High" <?php echo $priority === 'High' ? 'selected' : ''; ?>>High</option>
            </select>
        </div>

        <!-- status dropdown -->
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="Pending" <?php echo $status === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="Completed" <?php echo $status === 'Completed' ? 'selected' : ''; ?>>Completed</option>
            </select>
        </div>

        <!-- description textarea -->
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" 
                    class="form-control" 
                    rows="4"><?php echo htmlspecialchars($description ?? ''); ?></textarea>
        </div>

        <!-- update and cancel buttons -->
        <button type="submit" class="btn btn-primary">Update Task</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- imports footer -->
<?php include '../includes/footer.php'; ?>