<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
$connection = connectDatabase();

$result = $connection->query("SELECT * FROM users WHERE id = {$user['id']}");
if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['user'] = $user;
}

$accountResult = $connection->query("SELECT * FROM bank_accounts WHERE user_id = {$user['id']}");
$accounts = $accountResult ? $accountResult->fetch_all(MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SQL Injection Practice</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="brand">SQL Injection Practice Lab</div>
            <div class="nav-links">
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Welcome, <?php echo htmlspecialchars($user['full_name']); ?></h2>
            <p class="small">Username: <?php echo htmlspecialchars($user['username']); ?> | Email: <?php echo htmlspecialchars($user['email']); ?></p>
        </div>

        <div class="dashboard-grid">
            <div class="stat-box">
                <span>Available Balance</span>
                <strong>$<?php echo number_format((float)$user['balance'], 2); ?></strong>
            </div>
            <div class="stat-box">
                <span>Account Count</span>
                <strong><?php echo count($accounts); ?></strong>
            </div>
            <div class="stat-box">
                <span>Member Since</span>
                <strong><?php echo htmlspecialchars(date('M d, Y', strtotime($user['created_at']))); ?></strong>
            </div>
        </div>

        <div class="card">
            <h3>Bank Accounts</h3>
            <?php if (empty($accounts)): ?>
                <p class="small">No bank account found.</p>
            <?php else: ?>
                <table style="width:100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="text-align:left; padding:8px; border-bottom:1px solid #e5e7eb;">Account Name</th>
                            <th style="text-align:left; padding:8px; border-bottom:1px solid #e5e7eb;">Account Number</th>
                            <th style="text-align:right; padding:8px; border-bottom:1px solid #e5e7eb;">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($accounts as $account): ?>
                            <tr>
                                <td style="padding:10px 8px; border-bottom:1px solid #f3f4f6;">
                                    <?php echo htmlspecialchars($account['account_name']); ?>
                                </td>
                                <td style="padding:10px 8px; border-bottom:1px solid #f3f4f6;">
                                    <?php echo htmlspecialchars($account['account_number']); ?>
                                </td>
                                <td style="padding:10px 8px; text-align:right; border-bottom:1px solid #f3f4f6;">
                                    $<?php echo number_format((float)$account['balance'], 2); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div class="card" style="margin-top: 20px; text-align: center;">
            <div><strong>Created by Rabiul Islam</strong></div>
            <div class="small">
                <a href="https://github.com/rabiul-uiu" target="_blank" rel="noopener noreferrer">GitHub</a>
                |
                <a href="https://linkedin.com/in/rabiul-islam-in" target="_blank" rel="noopener noreferrer">LinkedIn</a>
            </div>
        </div>
    </div>
</body>
</html>
