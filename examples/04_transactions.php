<?php

require_once __DIR__ . '/../src/Database.php';

use Jules\CodeIgniterDbLibrary\Database;

// --- Transactions ---

// This example demonstrates how to use transactions to ensure data integrity
// when performing multiple related database operations.

// **Prerequisites:**
// 1. A database connection (see `01_database_connection.php`).
// 2. 'products' and 'categories' tables (see `03_handling_relationships.php`).

$db_params = [
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'test_db',
    'DBDriver' => 'MySQLi',
];

$db = new Database($db_params);

// --- Transaction Example ---

// In this example, we will insert a new category and a new product. If either
// operation fails, both will be rolled back.

$db->beginTransaction();

try {
    // Insert the new category
    $category_data = ['name' => 'Books'];
    $category_id = $db->insert('categories', $category_data);

    if (!$category_id) {
        throw new Exception("Failed to insert category.");
    }

    // Insert the new product
    $product_data = [
        'name' => 'The Pragmatic Programmer',
        'price' => 45.00,
        'category_id' => $category_id,
    ];
    $product_id = $db->insert('products', $product_data);

    if (!$product_id) {
        throw new Exception("Failed to insert product.");
    }

    // If both insertions are successful, commit the transaction
    $db->commit();
    echo "Transaction committed successfully.<br>";

} catch (Exception $e) {
    // If any operation fails, roll back the transaction
    $db->rollback();
    echo "Transaction rolled back: " . $e->getMessage() . "<br>";
}
