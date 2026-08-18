<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($username === '' || $password === '' || $fullName === '' || $email === '') {
        $errors[] = 'All fields are required.';
    } elseif (strlen($password) < 4) {
        $errors[] = 'Password must be at least 4 characters.';
    } else {
        $connection = connectDatabase();

        $checkQuery = "SELECT id FROM users WHERE username = '$username' OR email = '$email'";
        $checkResult = $connection->query($checkQuery);

        if ($checkResult && $checkResult->num_rows > 0) {
            $errors[] = 'Username or email already exists.';
        } else {
            $insertQuery = "INSERT INTO users (username, password, full_name, email, balance) VALUES ('$username', '$password', '$fullName', '$email', 0.00)";
            if ($connection->query($insertQuery)) {
                $userId = $connection->insert_id;
                $accountNumber = 'SA-' . str_pad((string)$userId, 6, '0', STR_PAD_LEFT);
                $accountQuery = "INSERT INTO bank_accounts (user_id, account_name, account_number, balance) VALUES ($userId, 'Primary Savings', '$accountNumber', 0.00)";
                $connection->query($accountQuery);
                $success = 'Registration successful. You can now log in.';
            } else {
                $errors[] = 'Registration failed: ' . $connection->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SQL Injection Practice</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="brand">SQL Injection Practice Lab</div>
            <div class="nav-links">
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card" style="max-width: 520px; margin: 60px auto 0;">
            <h2 class="center">Register</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert error"><?php echo htmlspecialchars($errors[0]); ?></div>
            <?php endif; ?>

            <?php if ($success !== ''): ?>
                <div class="alert success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" class="form-grid">
                <div>
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Your full name" required>
                </div>

                <div>
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Choose a username" required>
                </div>

                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com" required>
                </div>

                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Choose a password" required>
                </div>

                <button type="submit">Create Account</button>
            </form>

            <p class="small center">
                Already have an account? <a href="login.php">Login here</a>
            </p>

            <div class="small center" style="margin-top: 20px; border-top: 1px solid #e5e7eb; padding-top: 15px;">
                <div><strong>Created by Rabiul Islam</strong></div>
                <div>
                    <a href="https://github.com/rabiul-uiu" target="_blank" rel="noopener noreferrer">GitHub</a>
                    |
                    <a href="https://linkedin.com/in/rabiul-islam-in" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
