<?php

namespace core;

use Medoo\Medoo;

class Db
{

    private $table;

    private $connection;

    private $debug = false;

    private function __construct($table)
    {
        $this->table = $table;
        $this->connection = DbConnection::instance();
    }

    public static function table($table)
    {
        return new self($table);
    }

    public function select(array $columns = [], array $where = [])
    {
        $columns = $columns ?: '*';
        return $this->connection->select($this->table, $columns, $where);
    }

    public function insert(array $data)
    {
        $result = $this->connection->insert($this->table, $data);
        if (!$this->debug) {
            return $this->getLastInsertId();
        }

        return $result;
    }

    public function update(array $data, array $where)
    {
        $result = $this->connection->update($this->table, $data, $where);
        if (!$this->debug) {
            return $result->rowCount();
        }

        return $result;
    }

    public function delete(array $where)
    {
        $result = $this->connection->delete($this->table, $where);
        if (!$this->debug) {
            return $result->rowCount();
        }

        return $result;
    }

    public function debug()
    {
        $this->connection->debug();
        $this->debug = true;

        return $this;
    }

    public function error()
    {
        return $this->connection->error();
    }

    public function getLastInsertId()
    {
        return $this->connection->id();
    }

}