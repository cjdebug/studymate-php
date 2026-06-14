<?php
//databse connection
require_once '../config/database.php';

//starts a php session if it hasn't been started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title = 'Register';

//validation error and success message variables
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($name === '') {
        $errors[] = 'Name is required.';
    }

    if ($email === '') {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($password === '') {
        $errors[] = 'Password is required.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    if ($confirm_password === '') {
        $errors[] = 'Please confirm your password.';
    } elseif ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            $errors[] = 'This email is already registered.';
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                "INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)"
            );

            $stmt->execute([$name, $email, $password_hash]);

            $success = 'Registration successful. You can now login.';
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
                <h2 class="fw-bold mb-3 text-center">Create Account</h2>
                <p class="text-muted text-center mb-4">
                    Register to start managing your study tasks.
                </p>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($success); ?>
                        <br>
                        <a href="login.php" class="alert-link">Go to login</a>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            class="form-control" 
                            placeholder="Enter your full name"
                            value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                        >
                    </div>

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
                            placeholder="Enter password"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input 
                            type="password" 
                            name="confirm_password" 
                            class="form-control" 
                            placeholder="Confirm password"
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Register
                    </button>
                </form>

                <p class="text-center mt-3 mb-0">
                    Already have an account?
                    <a href="login.php">Login here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- imports footer.php -->
<?php require_once '../includes/footer.php'; ?>