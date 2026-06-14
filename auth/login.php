<?php
//databse connection
require_once '../config/database.php';

//starts a php session if it hasn't been started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title = 'Login';

//this array stores login errors to be displayed to the user if login fails
$errors = [];

//checking whether the form is submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //gets email and password from the form submission
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '') {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($password === '') {
        $errors[] = 'Password is required.';
    }

    //if there are no errors, proceed to check the database for the user
    if (empty($errors)) {
        //finding the user in the database by email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Verify the password using password_verify function with hashed password stored in the database
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            //sends user to dashboard after successful login
            header('Location: ../dashboard.php');
            exit;
        } else {
            $errors[] = 'Invalid email or password.';
        }
    }
}

//imports header.php
require_once '../includes/header.php';

?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-3 text-center">Login</h2>
                <p class="text-muted text-center mb-4">
                    Login to manage your study tasks.
                </p>

                <!-- Display errors if there are any -->
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <!-- loop through all errors -->
                            <?php foreach ($errors as $error): ?>
                                <!-- display errors safely as text -->
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- login form -->
                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Enter your email" 
                            value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter your password"
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Login
                    </button>
                </form>

                <!-- sends user to the register.php -->
                <p class="text-center mt-3 mb-0">
                    Do not have an account?
                    <a href="register.php">Register here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- imports footer.php -->
<?php require_once '../includes/footer.php'; ?>