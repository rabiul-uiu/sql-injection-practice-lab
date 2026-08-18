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
