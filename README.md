# CodeIgniter 4 Database Integration Library

A reusable CodeIgniter 4 database integration library that simplifies database operations.

## Installation

Install the library using Composer:

```bash
composer require jules/codeigniter-db-library
```

## Configuration

To use the library, you can either rely on the default database connection configured in your CodeIgniter 4 application, or you can provide the connection parameters programmatically.

### Default Connection

If you have a default database connection set up in `app/Config/Database.php`, you can instantiate the library without any parameters:

```php
use Jules\CodeIgniterDbLibrary\Database;

$db = new Database();
```

### Programmatic Connection

You can also connect to a database by passing the connection parameters to the constructor:

```php
use Jules\CodeIgniterDbLibrary\Database;

$params = [
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'my_database',
    'DBDriver' => 'MySQLi',
];

$db = new Database($params);
```

## Usage

### Selecting Data

```php
// Select all products
$products = $db->select('products');

// Select a single product
$product = $db->select('products', ['id' => 1]);
```

### Inserting Data

```php
$data = [
    'name' => 'New Product',
    'price' => 100,
];

$productId = $db->insert('products', $data);
```

### Updating Data

```php
$data = [
    'price' => 120,
];

$db->update('products', $data, ['id' => 1]);
```

### Deleting Data

```php
$db->delete('products', ['id' => 1]);
```

### Transactions

```php
try {
    $db->beginTransaction();

    // Perform database operations...
    $db->insert('products', ['name' => 'Another Product']);

    $db->commit();
} catch (\Exception $e) {
    $db->rollback();
    // Handle the exception...
}
```

### Raw Queries

```php
$result = $db->query('SELECT * FROM products');
```
