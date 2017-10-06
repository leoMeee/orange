<?php
namespace core;


class Config
{

    public static $configs;

    public static function Load()
    {
        $configPath = APP_PATH.'config/';
        $Directory = new \DirectoryIterator($configPath);
        foreach ($Directory as $file) {
            if ($file->isFile()) {
                $configFile = $configPath.$file->getFilename();
                $arr = include($configFile);
                $key = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                if (is_array($arr)) {
                    self::$configs[$key] = $arr;
                }
            }
        }
    }

    public static function get($key = null, $default = null)
    {
        if (!$key) {
            return self::$configs;
        }

        $tmp = explode('.', $key);
        if (count($tmp) == 1) {
            return self::$configs[$key] ?? $default;
        }

        return self::$configs[$tmp[0]][$tmp[1]] ?? $default;
    }

}