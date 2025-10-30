<?php

use Jules\CodeIgniterDbLibrary\Database;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        // Use an in-memory SQLite database for testing
        $params = [
            'DBDriver' => 'SQLite3',
            'database' => ':memory:',
        ];
        $this->db = new Database($params);

        // Create dummy tables for testing
        $this->db->query('CREATE TABLE products (id INTEGER PRIMARY KEY, name TEXT, category_id INTEGER)');
        $this->db->query('CREATE TABLE categories (id INTEGER PRIMARY KEY, name TEXT)');
    }

    public function testJoin()
    {
        $this->db->insert('categories', ['id' => 1, 'name' => 'Category 1']);
        $this->db->insert('products', ['name' => 'Product 1', 'category_id' => 1]);

        $builder = $this->db->db->table('products');
        $builder->join('categories', 'categories.id = products.category_id');
        $result = $builder->get()->getRow();

        $this->assertEquals('Category 1', $result->name);
    }

    public function testTransactionCommit()
    {
        $this->db->beginTransaction();
        $this->db->insert('products', ['name' => 'Product 1']);
        $this->db->commit();

        $result = $this->db->select('products', ['name' => 'Product 1'])->get()->getResult();
        $this->assertCount(1, $result);
    }

    public function testTransactionRollback()
    {
        $this->db->beginTransaction();
        $this->db->insert('products', ['name' => 'Product 2']);
        $this->db->rollback();

        $result = $this->db->select('products', ['name' => 'Product 2'])->get()->getResult();
        $this->assertCount(0, $result);
    }

    protected function tearDown(): void
    {
        $this->db->query('DROP TABLE products');
        $this->db->query('DROP TABLE categories');
    }
}
