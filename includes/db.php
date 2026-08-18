<?php

function connectDatabase($databaseName = null)
{
    $dbName = $databaseName !== null ? $databaseName : DB_NAME;
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, $dbName);

    if ($connection->connect_error) {
        die('Database connection failed: ' . $connection->connect_error);
    }

    return $connection;
}

function connectServer()
{
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS);

    if ($connection->connect_error) {
        die('MySQL connection failed: ' . $connection->connect_error);
    }

    return $connection;
}
 
function runQueryOrDbError($connection, $query)
{
    try {
        return $connection->query($query);
    } catch (mysqli_sql_exception $e) {
        // The exception points at the line that called this function.
        $caller = $e->getTrace()[0] ?? [];
        $file = $caller['file'] ?? $e->getFile();
        $line = $caller['line'] ?? $e->getLine();

        showDatabaseError($e->getCode(), $e->getMessage(), $query, $file, $line);
    }
}
 
function showDatabaseError($errorNumber, $errorMessage, $query, $file, $line)
{
    http_response_code(500);
    header('Content-Type: text/html; charset=UTF-8');

    $errorNumber  = htmlspecialchars((string)$errorNumber, ENT_QUOTES);
    $errorMessage = htmlspecialchars((string)$errorMessage, ENT_QUOTES);
    $query        = htmlspecialchars((string)$query, ENT_QUOTES);
    $file         = htmlspecialchars((string)$file, ENT_QUOTES);
    $line         = htmlspecialchars((string)$line, ENT_QUOTES);

    echo <<<HTML
<div style="border:1px solid #990000; padding:10px 20px; margin:20px; background:#fff; color:#000; font-family:'Courier New', monospace; font-size:14px; line-height:1.5;">
    <h4 style="margin:10px 0; font-size:18px;">A Database Error Occurred</h4>
    <p>Error Number: {$errorNumber}</p>
    <p>{$errorMessage}</p>
    <p>{$query}</p>
    <p>Filename: {$file}</p>
    <p>Line Number: {$line}</p>
</div>
HTML;

    exit;
}
