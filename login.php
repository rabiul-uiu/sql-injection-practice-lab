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
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = 'Username and password are required.';
    } else {
        $connection = connectDatabase();
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $connection->query($query);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user'] = $user;
            header('Location: dashboard.php');
            exit;
        }

        $errors[] = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SQL Injection Practice</title>
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
        <div class="card" style="max-width: 500px; margin: 60px auto 0;">
            <h2 class="center">Login</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert error"><?php echo htmlspecialchars($errors[0]); ?></div>
            <?php endif; ?>

            <?php if ($success !== ''): ?>
                <div class="alert success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" class="form-grid">
                <div>
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter username" required>
                </div>

                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>

                <button type="submit">Login</button>
            </form>

            <p class="small center">
                No account? <a href="/sql-injection/register.php">Register here</a>
            </p>

            <p class="small center">
                Demo users: admin / admin123, alice / alice123, bob / bob123
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
