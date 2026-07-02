<?php
//checks whether the user is authenticated, if not redirects to login page
require_once '../includes/auth_check.php';
//connects to database
require_once '../config/database.php';
//gets user id from session
$user_id = $_SESSION['user_id'];

//get subjects from database for the logged user
$stmt = $pdo->prepare("SELECT * FROM subjects WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
//take all rows returned by  the database and put them in an array called $subjects 
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = "My Subjects";

//imports header.php
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>My Subjects</h2>
        <a href="add.php" class="btn btn-secondary">Add Subject</a>
    </div>

    <!-- checks whether there are any subjects to display -->
    <?php if (empty($subjects)): ?>
        <div class="alert alert-info">
            No subjects added yet.
        </div>
    <?php else: ?>
        <div class="row">
            <!-- looping through each subject to create a card -->
            <?php foreach ($subjects as $subject): ?>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($subject['subject_name']); ?>
                            </h5>

                            <!-- displays subject description if available -->
                            <?php if (!empty($subject['description'])): ?>
                                <p class="card-text">
                                    <?php echo htmlspecialchars($subject['description']); ?>
                                </p>
                            <?php else: ?>
                                <p class="text-muted">No description added.</p>
                            <?php endif; ?>

                            <a href="edit.php?id=<?php echo $subject['id']; ?>" class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            <a href="delete.php?id=<?php echo $subject['id']; ?>" 
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this subject?');">
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- imports footer -->
<?php include '../includes/footer.php'; ?>