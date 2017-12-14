<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/10/3
 * Time: 下午9:29
 */

namespace core;


class Model extends Object
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

    public function setProperties($properties)
    {
        $this->properties = $properties;
        $this->setExists(true);
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function getPk()
    {
        return $this->pk;
    }

    public function isExists()
    {
        return $this->exists;
    }

    public function setExists(bool $value)
    {
        $this->exists = $value;
    }

    public function save()
    {
        $result = false;

        if (!empty($this->newProperties)) {
            if ($this->isExists()) {
                $result = $this->update();
            } else {
                $result = $this->insert();
            }
        }

        if ($result) {
            $this->newProperties = [];
        }

        return $result;
    }

    public function insert()
    {
        $result = $this->getQuery()->insert($this->newProperties);
        if ($result) {
            $newData = $this->getQuery()->where($this->pk, $this->getQuery()->getLastInsertId())->get();
            $this->setProperties($newData);
            return true;
        }

        return false;
    }

    public function update()
    {
        $result = $this->getQuery()->where($this->pk, $this->getId())->update($this->newProperties);
        if ($result) {
            $newData = $this->getQuery()->where($this->pk, $this->getId())->get();
            $this->setProperties($newData);
            return true;
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

    public static function __callStatic($name, $arguments)
    {
        $object = new ModelQuery(new static());
        if (method_exists($object, $name)) {
            return call_user_func_array([$object, $name], $arguments);
        }
        throw new \Exception('method ' . $name . ' is not exists');
    }

    public function getId()
    {
        return $this->getProperties()[$this->pk] ?? null;
    }

    public function getQuery(): Db
    {
        if (!$this->query) {
            $this->query = Db::table($this->table);
        }
        return $this->query;
    }

}