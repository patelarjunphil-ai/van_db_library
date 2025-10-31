<?php

namespace Jules\CodeIgniterDbLibrary;

use Config\Database as ConfigDatabase;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Psr\Log\LoggerInterface;

class Database
{
    /** @var \CodeIgniter\Database\BaseConnection */
    public $db;

    /** @var LoggerInterface */
    protected $logger;

    public function __construct(array $params = [], LoggerInterface $logger = null)
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

        $this->logger = $logger;
    }

    public function select(string $table, array $where = [])
    {
        return $this->db->table($table)->where($where);
    }

    public function get()
    {
        return $this->db->get();
    }

    public function limit(int $limit, int $offset = 0)
    {
        return $this->db->limit($limit, $offset);
    }

    public function orderBy(string $orderBy, string $direction = 'ASC')
    {
        return $this->db->orderBy($orderBy, $direction);
    }

    public function groupBy(string $groupBy)
    {
        return $this->db->groupBy($groupBy);
    }


    public function insert(string $table, array $data)
    {
        try {
            $this->db->table($table)->insert($data);
            return $this->db->insertID();
        } catch (DatabaseException $e) {
            if ($this->logger) {
                $this->logger->error($e->getMessage());
            }
            return false;
        }
    }

    public function update(string $table, array $data, array $where)
    {
        try {
            return $this->db->table($table)->where($where)->update($data);
        } catch (DatabaseException $e) {
            if ($this->logger) {
                $this->logger->error($e->getMessage());
            }
            return false;
        }
    }

    public function delete(string $table, array $where)
    {
        try {
            return $this->db->table($table)->where($where)->delete();
        } catch (DatabaseException $e) {
            if ($this->logger) {
                $this->logger->error($e->getMessage());
            }
            return false;
        }
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
        try {
            return $this->db->query($sql);
        } catch (DatabaseException $e) {
            if ($this->logger) {
                $this->logger->error($e->getMessage());
            }
            return false;
        }
    }

    public function join(string $table, string $condition, string $type = 'inner')
    {
        return $this->db->table($table)->join($table, $condition, $type);
    }
}
