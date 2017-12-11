<?php

namespace core;

use Medoo\Medoo;

class Db
{

    private $table;

    private $connection;

    private $debug = false;

    private $where = [];

    private function __construct($table)
    {
        $this->table = $table;
        $this->connection = DbConnection::instance();
    }

    /**
     * Set the query table name
     * @param $table
     * @return Db
     */
    public static function table($table)
    {
        return new self($table);
    }

    /**
     * Get only one record from table
     * @param array $where
     * @param array $columns
     * @return array|bool|mixed
     */
    public function get(array $where = [], array $columns = [])
    {
        $columns = $columns ?: '*';
        return $this->connection->get($this->table, $columns, $where);
    }

    /**
     * Select data from database
     * @param array $columns
     * @return array|bool
     */
    public function select(array $columns = [])
    {
        $columns = $columns ?: '*';
        return $this->connection->select($this->table, $columns, $this->where);
    }


    public function limit(int $start, int $end = null)
    {
        if (func_num_args() >= 2) {
            return $this->setWhere(['LIMIT' => [$start, $end]]);
        }

        return $this->setWhere(['LIMIT' => $start]);
    }

    /**
     * Insert new records in table
     * @param array $data
     * @return bool|int|\PDOStatement|string
     */
    public function insert(array $data)
    {
        $result = $this->connection->insert($this->table, $data);
        if (!$this->debug) {
            return $this->getLastInsertId();
        }

        return $result;
    }

    /**
     * Modify data in table
     * @param array $data
     * @param array $where
     * @return bool|int
     */
    public function update(array $data, array $where)
    {
        $result = $this->connection->update($this->table, $data, $where);
        if (!$this->debug) {
            return $result->rowCount();
        }

        return $result;
    }

    /**
     * Delete data from table
     * @param array $where
     * @return bool|int
     */
    public function delete(array $where)
    {
        $result = $this->connection->delete($this->table, $where);
        if (!$this->debug) {
            return $result->rowCount();
        }

        return $result;
    }

    /**
     * Counts the number of rows
     * @param array $where
     * @return bool|int
     */
    public function count(array $where = [])
    {
        return $this->connection->count($this->table, $where);
    }

    /**
     * Start transaction
     */
    public function beginTransaction()
    {
        $this->connection->pdo->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commit()
    {
        $this->connection->pdo->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollBack()
    {
        $this->connection->pdo->rollBack();
    }

    private function setWhere(array $where)
    {
        if (!empty($where)) {
            $this->where = array_merge($this->where, $where);
        }
        return $this;
    }

    /**
     * Output the generated SQL without execute it.
     * @return $this
     */
    public function debug()
    {
        $this->connection->debug();
        $this->debug = true;

        return $this;
    }

    /**
     * Return error information associated with the last operation
     * @return null
     */
    public function error()
    {
        return $this->connection->error();
    }

    /**
     * Get information about the connected database
     * @return array
     */
    public function info()
    {
        return $this->connection->info();
    }

    /**
     * Return the all executed queries
     * @return array
     */
    public function queryLog()
    {
        return $this->connection->log();
    }

    /**
     * Returns the ID of the last inserted row
     * @return int|string
     */
    public function getLastInsertId()
    {
        return $this->connection->id();
    }

}