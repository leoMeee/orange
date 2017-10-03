<?php
namespace core;

class Autoload
{
    private static $loadCache = array();

    public function register()
    {
        spl_autoload_register('self::load');
    }

    private static function load($className)
    {
        $path = ROOT_PATH.'/'.str_replace('\\', '/', $className).'.'.'php';

        if (isset(self::$loadCache[$path])) {
            return true;
        }
        if (file_exists($path)) {
            include_once($path);
            self::$loadCache[] = $path;
        } else {
            self::classNotExists($className);
        }

        return true;
    }

    private static function classNotExists($className)
    {
        throw new \Exception('class `'.$className.'` 不存在!');
    }
}