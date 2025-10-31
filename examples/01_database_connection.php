<?php

// Autoload the necessary classes
require_once __DIR__ . '/../src/Database.php';

use Jules\CodeIgniterDbLibrary\Database;

// --- Database Connection ---

// To connect to the database, you can either use the default CodeIgniter 4
// connection or provide your own connection parameters.

// 1. Using the default connection from `app/Config/Database.php`
// This assumes you have CodeIgniter 4's `ENVIRONMENT` constant defined.
// Make sure to configure your default database connection in that file.

// try {
//     $db = new Database();
//     echo "Successfully connected to the default database.<br>";
// } catch (Exception $e) {
//     echo "Failed to connect to the default database: " . $e->getMessage() . "<br>";
// }

// 2. Providing custom connection parameters
// This is useful for connecting to a different database or when not using
// the full CodeIgniter 4 framework.

$db_params = [
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'test_db',
    'DBDriver' => 'MySQLi',
];

try {
    $db = new Database($db_params);
    echo "Successfully connected to the custom database.<br>";
} catch (Exception $e) {
    echo "Failed to connect to the custom database: " . $e->getMessage() . "<br>";
}

// The $db object is now ready to be used for database operations.
