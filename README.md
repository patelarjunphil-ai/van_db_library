# CodeIgniter 4 Database Integration Library

A reusable CodeIgniter 4 database integration library that simplifies database operations, providing a streamlined and efficient way to interact with your database across multiple projects.

## Features

- **Simplified CRUD Operations**: Easy-to-use methods for `select`, `insert`, `update`, and `delete` operations.
- **Advanced Query Building**: Chainable methods for `limit`, `orderBy`, and `groupBy`.
- **Relationship Handling**: `join` method to easily handle relationships between tables.
- **Transaction Support**: Full support for database transactions to ensure data integrity.
- **Error Handling & Logging**: Built-in error handling and logging for easier debugging.
- **Flexible Configuration**: Supports both default CodeIgniter 4 database connections and custom connection parameters.
- **Multi-Database Support**: Designed to be flexible enough to support multiple database systems like MySQL.

## Manual Installation

Follow these steps to integrate the library into your existing CodeIgniter 4 project:

1.  **Clone the Repository**
    Clone this repository into a directory of your choice, for example, `my-app/libraries`:
    ```bash
    git clone https://github.com/jules/codeigniter-db-library.git my-app/libraries/codeigniter-db-library
    ```

2.  **Add to Autoloader**
    Open your `app/Config/Autoload.php` file and add the library's namespace to the `$psr4` array:
    ```php
    'Jules\\CodeIgniterDbLibrary' => APPPATH . '../libraries/codeigniter-db-library/src',
    ```

3.  **Configure Database**
    Ensure your database connection is configured in `app/Config/Database.php`. The library can use the default connection, or you can provide custom parameters.

## Usage Examples

### 1. Database Connection

You can connect to the database using either the default CodeIgniter 4 connection or by providing custom parameters.

**Default Connection:**
```php
use Jules\CodeIgniterDbLibrary\Database;

$db = new Database();
```

**Custom Connection:**
```php
use Jules\CodeIgniterDbLibrary\Database;

$db_params = [
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'test_db',
    'DBDriver' => 'MySQLi',
];

$db = new Database($db_params);
```

### 2. CRUD Operations

**Insert:**
```php
$product_data = [
    'name' => 'Laptop',
    'price' => 1200.00,
    'category_id' => 1,
];

$product_id = $db->insert('products', $product_data);
```

**Select:**
```php
// Get all products
$all_products = $db->select('products')->get()->getResult();

// Get a single product
$product = $db->select('products', ['id' => 1])->get()->getRow();
```

**Update:**
```php
$updated_data = [
    'price' => 1150.00,
];

$db->update('products', $updated_data, ['id' => 1]);
```

**Delete:**
```php
$db->delete('products', ['id' => 1]);
```

### 3. Handling Relationships (Joins)

Retrieve products with their corresponding category names:

```php
$products_with_categories = $db->select('products')
    ->join('categories', 'categories.id = products.category_id')
    ->select('products.*, categories.name as category_name')
    ->get()
    ->getResult();
```

### 4. Transactions

Ensure data integrity by wrapping multiple database operations in a transaction:

```php
$db->beginTransaction();

try {
    $db->insert('categories', ['name' => 'Books']);
    $db->insert('products', ['name' => 'The Pragmatic Programmer', 'price' => 45.00, 'category_id' => 3]);
    $db->commit();
} catch (Exception $e) {
    $db->rollback();
    // Handle the exception
}
```

For more detailed examples, see the `examples` directory.
