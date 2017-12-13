<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/10/3
 * Time: 下午9:29
 */

namespace core;


abstract class Model
{
    protected $table;

    protected $pk = 'id';

    protected $properties = [];

    protected $newProperties = [];

    protected $exists = false;

    protected $query;

    public function getTable()
    {
        return $this->table;
    }

    protected function setProperties($properties)
    {
        $this->properties = $properties;
    }

    protected function getProperties()
    {
        return $this->properties;
    }

    public function isExists()
    {
        return $this->exists;
    }

    public function find($id)
    {
        $result = $this->getQuery()->where($this->pk, $id)->get();
        if ($result) {
            $this->setProperties($result);
            $this->exists = true;
            return $this;
        }

        return null;
    }

    public function save()
    {
        if ($this->isExists()) {
            $result = $this->update();
        } else {
            $result = $this->insert();
        }

        if ($result) {
            $this->newProperties = [];
        }

        return $result;
    }

    public function insert()
    {
        if (!empty($this->newProperties)) {
            $result = $this->getQuery()->insert($this->newProperties);
            if ($result) {
                $newData = $this->getQuery()->where($this->pk, $this->getQuery()->getLastInsertId())->get();
                $this->setProperties($newData);
                $this->exists = true;
                return true;
            }
            return false;
        }
        return false;
    }

    public function update()
    {
        if (!empty($this->newProperties)) {
            $result = $this->getQuery()->where($this->pk, $this->getId())->update($this->newProperties);

            if ($result) {
                $newData = $this->getQuery()->where($this->pk, $this->getId())->get();
                $this->setProperties($newData);
                return true;
            }
            return false;
        }
        return false;
    }

    public function __get($name)
    {
        return $this->properties[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->newProperties[$name] = $value;
    }

    public function getId()
    {
        return $this->getProperties()[$this->pk] ?? null;
    }

    protected function getQuery()
    {
        if (!$this->query) {
            $this->query = Db::table($this->table);
        }
        return $this->query;
    }
}