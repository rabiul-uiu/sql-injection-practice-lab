<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';

$serverConnection = connectServer();

$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if (!$serverConnection->query($sql)) {
    die('Failed to create database: ' . $serverConnection->error);
}

$connection = connectDatabase();

$sqlFile = __DIR__ . '/../database/schema.sql';
if (!file_exists($sqlFile)) {
    die('Schema file not found: ' . $sqlFile);
}

$schemaSql = file_get_contents($sqlFile);

if ($schemaSql === false) {
    die('Unable to read schema file.');
}

if (!$connection->multi_query($schemaSql)) {
    die('Schema import failed: ' . $connection->error);
}

while ($connection->more_results()) {
    $connection->next_result();
}

$seedFile = __DIR__ . '/../database/seed.sql';
if (file_exists($seedFile)) {
    $seedSql = file_get_contents($seedFile);
    if ($seedSql !== false) {
        if (!$connection->multi_query($seedSql)) {
            die('Seed import failed: ' . $connection->error);
        }
        while ($connection->more_results()) {
            $connection->next_result();
        }
    }
}

header('Location: ../login.php');
exit;
