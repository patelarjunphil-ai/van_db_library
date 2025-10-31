<?php

require_once __DIR__ . '/../src/Database.php';

use Jules\CodeIgniterDbLibrary\Database;

// --- CRUD Operations ---

// This example demonstrates how to perform Create, Read, Update, and Delete
// operations on a 'products' table.

// **Prerequisites:**
// 1. A database connection (see `01_database_connection.php`).
// 2. A 'products' table in your database with the following schema:
//    CREATE TABLE products (
//        id INT AUTO_INCREMENT PRIMARY KEY,
//        name VARCHAR(255) NOT NULL,
//        price DECIMAL(10, 2) NOT NULL,
//        category_id INT NOT NULL
//    );

$db_params = [
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'test_db',
    'DBDriver' => 'MySQLi',
];

$db = new Database($db_params);

// --- Create (Insert) ---

$product_data = [
    'name' => 'Laptop',
    'price' => 1200.00,
    'category_id' => 1,
];

$product_id = $db->insert('products', $product_data);

if ($product_id) {
    echo "Product inserted with ID: $product_id<br>";
} else {
    echo "Failed to insert product.<br>";
}

// --- Read (Select) ---

// Get all products
$all_products = $db->select('products')->get()->getResult();
echo "All products: <pre>" . print_r($all_products, true) . "</pre>";

// Get a single product by ID
$product = $db->select('products', ['id' => $product_id])->get()->getRow();
echo "Single product: <pre>" . print_r($product, true) . "</pre>";

// --- Update ---

$updated_data = [
    'price' => 1150.00,
];

$rows_affected = $db->update('products', $updated_data, ['id' => $product_id]);

if ($rows_affected) {
    echo "Product updated successfully.<br>";
} else {
    echo "Failed to update product.<br>";
}

// --- Delete ---

$rows_deleted = $db->delete('products', ['id' => $product_id]);

if ($rows_deleted) {
    echo "Product deleted successfully.<br>";
} else {
    echo "Failed to delete product.<br>";
}
