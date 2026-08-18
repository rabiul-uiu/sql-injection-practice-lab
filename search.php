<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';

$q   = $_GET['q']  ?? '';
$id  = $_GET['id'] ?? '';

$results = [];
$errorMessage = '';
$runQuery = '';

$connection = connectDatabase();

if ($q !== '' || $id !== '') {
    if ($id !== '') {
        $runQuery = "SELECT id, username, full_name, email, balance FROM users WHERE id = $id";
    } else {
        $runQuery = "SELECT id, username, full_name, email, balance FROM users WHERE full_name LIKE '%$q%'";
    }

    $result = runQueryOrDbError($connection, $runQuery);
    if ($result) {
        $results = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Search - SQL Injection Practice</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="brand">SQL Injection Practice Lab</div>
            <div class="nav-links">
                <a href="search.php">Search</a>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2>User Directory Search</h2>
            <p class="small">
                Search the public user directory by name. The search term is sent as a
                GET parameter, so it appears directly in the URL
                (e.g. <code>search.php?q=alice</code>).
            </p>

            <form method="GET" class="form-grid" style="max-width: 520px;">
                <div>
                    <label for="q">Search by name</label>
                    <input type="text" id="q" name="q"
                           value="<?php echo htmlspecialchars($q); ?>"
                           placeholder="e.g. alice">
                </div>
                <button type="submit">Search</button>
            </form>

            <p class="small" style="margin-top: 15px;">
                You can also look up a single user by id:
                <code>search.php?id=1</code>
            </p>
        </div>

        <?php if ($runQuery !== ''): ?>
            <div class="card">
                <h3>Query that was executed</h3>
                <p class="small"><code><?php echo htmlspecialchars($runQuery); ?></code></p>
            </div>
        <?php endif; ?>

        <?php if ($errorMessage !== ''): ?>
            <div class="card">
                <div class="alert error"><?php echo htmlspecialchars($errorMessage); ?></div>
            </div>
        <?php endif; ?>

        <?php if ($q !== '' || $id !== ''): ?>
            <div class="card">
                <h3>Results (<?php echo count($results); ?>)</h3>
                <?php if (empty($results)): ?>
                    <p class="small">No matching users found.</p>
                <?php else: ?>
                    <table style="width:100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="text-align:left; padding:8px; border-bottom:1px solid #e5e7eb;">ID</th>
                                <th style="text-align:left; padding:8px; border-bottom:1px solid #e5e7eb;">Username</th>
                                <th style="text-align:left; padding:8px; border-bottom:1px solid #e5e7eb;">Full Name</th>
                                <th style="text-align:left; padding:8px; border-bottom:1px solid #e5e7eb;">Email</th>
                                <th style="text-align:right; padding:8px; border-bottom:1px solid #e5e7eb;">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $row): ?>
                                <tr>
                                    <td style="padding:10px 8px; border-bottom:1px solid #f3f4f6;"><?php echo htmlspecialchars((string)($row['id'] ?? '')); ?></td>
                                    <td style="padding:10px 8px; border-bottom:1px solid #f3f4f6;"><?php echo htmlspecialchars((string)($row['username'] ?? '')); ?></td>
                                    <td style="padding:10px 8px; border-bottom:1px solid #f3f4f6;"><?php echo htmlspecialchars((string)($row['full_name'] ?? '')); ?></td>
                                    <td style="padding:10px 8px; border-bottom:1px solid #f3f4f6;"><?php echo htmlspecialchars((string)($row['email'] ?? '')); ?></td>
                                    <td style="padding:10px 8px; text-align:right; border-bottom:1px solid #f3f4f6;"><?php echo htmlspecialchars((string)($row['balance'] ?? '')); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="card" style="text-align: center;">
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
