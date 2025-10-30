<?php

namespace Jules\CodeIgniterDbLibrary;

use Config\Database as ConfigDatabase;

class Database
{
    public $db;

    public function __construct(array $params = [])
    {
        // If no parameters are provided, use the default connection
        if (empty($params)) {
            $this->db = ConfigDatabase::connect();
        } else {
            // Create a new database connection group programmatically
            $db_config = [
                'DSN'      => '',
                'hostname' => $params['hostname'] ?? 'localhost',
                'username' => $params['username'] ?? '',
                'password' => $params['password'] ?? '',
                'database' => $params['database'] ?? '',
                'DBDriver' => $params['DBDriver'] ?? 'MySQLi',
                'DBPrefix' => $params['DBPrefix'] ?? '',
                'pConnect' => $params['pConnect'] ?? false,
                'DBDebug'  => $params['DBDebug'] ?? (ENVIRONMENT !== 'production'),
                'charset'  => $params['charset'] ?? 'utf8',
                'DBCollat' => $params['DBCollat'] ?? 'utf8_general_ci',
                'swapPre'  => '',
                'encrypt'  => false,
                'compress' => false,
                'strictOn' => false,
                'failover' => [],
            ];
            $this->db = ConfigDatabase::connect($db_config);
        }
    }

    public function select(string $table, array $where = [])
    {
        return $this->db->table($table)->where($where);
    }

    public function insert(string $table, array $data)
    {
        $this->db->table($table)->insert($data);
        return $this->db->insertID();
    }

    public function update(string $table, array $data, array $where)
    {
        return $this->db->table($table)->where($where)->update($data);
    }

    public function delete(string $table, array $where)
    {
        return $this->db->table($table)->where($where)->delete();
    }

    public function beginTransaction()
    {
        $this->db->transBegin();
    }

    public function commit()
    {
        $this->db->transCommit();
    }

    public function rollback()
    {
        $this->db->transRollback();
    }

    public function query(string $sql)
    {
        return $this->db->query($sql);
    }

    public function join(string $table, string $condition, string $type = 'inner')
    {
        return $this->db->table($table)->join($table, $condition, $type);
    }
}
