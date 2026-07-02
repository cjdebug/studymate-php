<?php
//checks if the user is logged in, if not redirects to login page
require_once '../includes/auth_check.php';
//connects to databasse
require_once '../config/database.php';

//gets userID and subject ID
$user_id = $_SESSION['user_id'];
$subject_id = $_GET['id'] ?? null;

//if no subject ID is provided, redirect to index page
if (!$subject_id) {
    header("Location: index.php");
    exit;
}

//finds the subject in the database that matches the provided subject ID and belongs to the logged user
$stmt = $pdo->prepare("SELECT * FROM subjects WHERE id = ? AND user_id = ?");
$stmt->execute([$subject_id, $user_id]);
$subject = $stmt->fetch(PDO::FETCH_ASSOC);

//if the subject doesn't exist or doesn't belong to the user, redirect to index page
if (!$subject) {
    header("Location: index.php");
    exit;
}

//stores validation errors
$errors = [];
//store old subject name
$subject_name = $subject['subject_name'];
//store old description
$description = $subject['description'];

//check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_name = trim($_POST['subject_name']);
    $description = trim($_POST['description']);

    if (empty($subject_name)) {
        $errors[] = "Subject name is required.";
    }

    //update database if there are no validation errors
    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE subjects SET subject_name = ?, description = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$subject_name, $description, $subject_id, $user_id]);

        header("Location: index.php");
        exit;
    }
}

$page_title = "Edit Subject";
//imports header.php
include '../includes/header.php';
?>

<div class="container mt-4">
    <h2>Edit Subject</h2>
    <!-- shows validation errors if there are any -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="subject_name" class="form-label">Subject Name</label>
            <input 
                type="text" 
                name="subject_name" 
                id="subject_name" 
                class="form-control" 
                value="<?php echo htmlspecialchars($subject_name); ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea 
                name="description" 
                id="description" 
                class="form-control" 
                rows="4"
            ><?php echo htmlspecialchars($description); ?></textarea>
        </div>

        <!-- update and cancel buttons -->
        <button type="submit" class="btn btn-primary">Update Subject</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- imports footer -->
<?php include '../includes/footer.php'; ?>