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

    public function __construct()
    {
    }

    public function getTable()
    {
        return $this->table;
    }
}