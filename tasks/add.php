<?php
//checks whether the user is logged in, if not redirects to login page
require_once '../includes/auth_check.php';
//connects to database
require_once '../config/database.php';

//gets logged in user's ID from session
$user_id = $_SESSION['user_id'];

//creating empty variables
$errors = [];
$title = '';
$description = '';
$subject_id = '';
$deadline = '';
$priority = 'Medium';

//Prepares the SQL query
$stmt = $pdo->prepare("SELECT * FROM subjects WHERE user_id = ? ORDER BY subject_name ASC");
//runs the query
$stmt->execute([$user_id]);
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

//checks if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //getting values from the form
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $subject_id = $_POST['subject_id'] ?? '';
    $deadline = $_POST['deadline'] ?? '';
    $priority = $_POST['priority'] ?? 'Medium';

    //checks whether the title is empty
    if (empty($title)) {
        $errors[] = "Task title is required.";
    }

    //checks whether the selected priority is valid
    if (!in_array($priority, ['Low', 'Medium', 'High'])) {
        $errors[] = "Invalid priority selected.";
    }

    //saving only if there are no validation errors
    if (empty($errors)) {
        //if subject_id is not empty, use the selected subject ID. If subject_id is empty, save null
        $subject_value = !empty($subject_id) ? $subject_id : null;
        //if deadline is not empty, use the provided deadline. If deadline is empty, save null
        $deadline_value = !empty($deadline) ? $deadline : null;

        //prepares the INSERT query, insert data into tasks table
        $stmt = $pdo->prepare("
            INSERT INTO tasks (user_id, subject_id, title, description, deadline, priority, status)
            VALUES (?, ?, ?, ?, ?, ?, 'Pending')
        ");

        //execute the INSERT query, saves the task into the database
        $stmt->execute([
            $user_id,
            $subject_value,
            $title,
            $description,
            $deadline_value,
            $priority
        ]);

        //redirecting back to the task list
        header("Location: index.php");
        exit;
    }
}

$page_title = "Add Task";
//includes header.php
include '../includes/header.php';
?>

<div class="container mt-4">
    <h2>Add Task</h2>

    <!-- checks if there are any errors -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- form creation -->
    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Task Title</label>
            <input type="text" 
                name="title" 
                class="form-control" 
                value="<?php echo htmlspecialchars($title); ?>" 
                required>
        </div>

        <!-- creates subject dropdown -->
        <div class="mb-3">
            <label class="form-label">Subject</label>
            <select name="subject_id" class="form-select">
                <option value="">No subject</option>

                <!-- loops through all subjects from the database -->
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?php echo $subject['id']; ?>"
                        <?php echo $subject_id == $subject['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($subject['subject_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- this creates the datepicker, user can select a deadline -->
        <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input type="date" 
                name="deadline" 
                class="form-control"
                value="<?php echo htmlspecialchars($deadline); ?>">
        </div>

        <!-- this let user select priority -->
        <div class="mb-3">
            <label class="form-label">Priority</label>
            <select name="priority" class="form-select">
                <option value="Low" <?php echo $priority === 'Low' ? 'selected' : ''; ?>>Low</option>
                <option value="Medium" <?php echo $priority === 'Medium' ? 'selected' : ''; ?>>Medium</option>
                <option value="High" <?php echo $priority === 'High' ? 'selected' : ''; ?>>High</option>
            </select>
        </div>

        <!-- creates large text box for task description, this is optional -->
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" 
                    class="form-control" 
                    rows="4"><?php echo htmlspecialchars($description); ?></textarea>
        </div>

        <!-- update and cancel buttons -->
        <button type="submit" class="btn btn-primary">Save Task</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- imports footer -->
<?php include '../includes/footer.php'; ?>