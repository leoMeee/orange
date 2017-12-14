<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/10/3
 * Time: 下午9:29
 */

namespace core;


class ModelQuery extends Object
{
    protected $model;

    protected $query;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        $result = $this->getQuery()->where($this->model->getPk(), $id)->get();
        if ($result) {
            $this->model->setProperties($result);
            return $this->model;
        }

        return null;
    }

    public function all(array $column = [])
    {
        $results = $this->getQuery()->select($column);
        array_walk($results, function (&$result) {
            $className = $this->model->className();
            /** @var Model $model */
            $model = new $className();
            $model->setProperties($result);
            $result = $model;
        });
        return $results;
    }

    protected function getQuery(): Db
    {
        return $this->model->getQuery();
    }
}