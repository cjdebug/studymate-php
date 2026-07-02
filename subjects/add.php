<?php
//checks whether the user logged in, if not redirects to login page
require_once '../includes/auth_check.php';
//connects to database
require_once '../config/database.php';

//empty variables to hold form data and errors
$errors = [];
$subject_name = '';
$description = '';

//check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //get form values and trim whitespace
    $subject_name = trim($_POST['subject_name']);
    $description = trim($_POST['description']);

    //validate subject name
    if (empty($subject_name)) {
        $errors[] = "Subject name is required.";
    }

    //if no errors saves to the database
    if (empty($errors)) {
        //inserts userID, subject_name and description into the subjects table in the database
        $stmt = $pdo->prepare("INSERT INTO subjects (user_id, subject_name, description) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $subject_name, $description]);

        //redirecting after saving
        header("Location: index.php");
        exit;
    }
}

$page_title = "Add Subject";
//imports header.php
include '../includes/header.php';
?>

<div class="container mt-4">
    <h2>Add Subject</h2>

    <!-- shows if there are any errors -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- form for adding a new subject -->
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
        <button type="submit" class="btn btn-primary">Save Subject</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- imports footer -->
<?php include '../includes/footer.php'; ?>