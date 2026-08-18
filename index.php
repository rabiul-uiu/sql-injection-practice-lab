<?php
require_once __DIR__ . '/includes/config.php';

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

header('Location: login.php');
exit;
