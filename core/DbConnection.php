<?php

namespace core;

use Medoo\Medoo;

class DbConnection
{
    /**
     * @var Medoo
     */
    private static $connection;

    public static function instance(): Medoo
    {
        if (!self::$connection) {
            self::$connection = new Medoo([
                'database_type' => Config::get('database.dbms'),
                'database_name' => Config::get('database.name'),
                'server' => Config::get('database.host'),
                'username' => Config::get('database.user'),
                'password' => Config::get('database.password'),
            ]);
        }

        return self::$connection;
    }
}