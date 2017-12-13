<?php

namespace core;

use Medoo\Medoo;

class Db
{

    private $table;

    private $connection;

    private $debug = false;

    private $where = [];

    private $queryCondition = [];

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
     * @param array $columns
     * @return array|bool|mixed
     */
    public function get(array $columns = [])
    {
        $columns = $columns ?: '*';
        return $this->connection->get($this->table, $columns, $this->where);
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

    public function order(array $order)
    {
        array_walk($order, function (&$item) {
            $item = strtoupper($item);
        });
        return $this->setWhere(['ORDER' => $order]);
    }

    /**
     * @param $column
     * @param $condition
     * @param null $value
     * @return Db
     */
    public function where($column, $condition, $value = null)
    {
        if (func_num_args() <= 2) {
            $this->queryCondition = array_merge($this->queryCondition, [$column => $condition]);
        } else {
            $column = sprintf('%s[%s]', $column, $this->formatCondition($condition));

            $this->queryCondition = array_merge($this->queryCondition, [$column => $value]);
        }

        return $this->setWhere($this->queryCondition);
    }


    public function whereBetween($column, $start, $end)
    {
        $column = sprintf('%s[<>]', $column);
        $this->queryCondition = array_merge($this->queryCondition, [$column => [$start, $end]]);

        return $this->setWhere($this->queryCondition);
    }

    public function whereNotBetween($column, $start, $end)
    {
        $column = sprintf('%s[><]', $column);
        $this->queryCondition = array_merge($this->queryCondition, [$column => [$start, $end]]);

        return $this->setWhere($this->queryCondition);
    }

    public function whereIn($column, array $values)
    {
        return $this->where($column, $values);
    }

    public function whereNotIn($column, array $values)
    {
        return $this->where($column, '!=', $values);
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
     * @return bool|int
     */
    public function update(array $data)
    {
        $result = $this->connection->update($this->table, $data, $this->where);
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

    private function formatCondition($condition)
    {
        $condition = trim($condition);
        $default = [
            '=' => '=',
            '!=' => '!',
            '>' => '>',
            '<' => '<',
            '>=' => '>=',
            '<=' => '<=',
            'like' => '~',
            'not like' => '!~',
        ];
        if (!array_key_exists($condition, $default)) {
            throw new \Exception('condition ' . $condition . ' not exists');
        }

        return $default[$condition];
    }
}