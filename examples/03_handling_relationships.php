<?php

require_once __DIR__ . '/../src/Database.php';

use Jules\CodeIgniterDbLibrary\Database;

// --- Handling Relationships ---

// This example demonstrates how to handle relationships between tables using
// joins. We will retrieve products and their corresponding categories.

// **Prerequisites:**
// 1. A database connection (see `01_database_connection.php`).
// 2. 'products' and 'categories' tables with the following schemas:
//    CREATE TABLE products (
//        id INT AUTO_INCREMENT PRIMARY KEY,
//        name VARCHAR(255) NOT NULL,
//        price DECIMAL(10, 2) NOT NULL,
//        category_id INT NOT NULL
//    );
//    CREATE TABLE categories (
//        id INT AUTO_INCREMENT PRIMARY KEY,
//        name VARCHAR(255) NOT NULL
//    );

$db_params = [
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'test_db',
    'DBDriver' => 'MySQLi',
];

$db = new Database($db_params);

// --- Insert Sample Data ---

$category_id = $db->insert('categories', ['name' => 'Electronics']);
$db->insert('products', ['name' => 'Laptop', 'price' => 1200.00, 'category_id' => $category_id]);
$db->insert('products', ['name' => 'Mouse', 'price' => 25.00, 'category_id' => $category_id]);

// --- Join Operation ---

// Select products with their category names
$products_with_categories = $db->select('products')
    ->join('categories', 'categories.id = products.category_id')
    ->select('products.*, categories.name as category_name')
    ->get()
    ->getResult();

echo "Products with categories: <pre>" . print_r($products_with_categories, true) . "</pre>";
