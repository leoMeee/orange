<?php
namespace core;


class Controller
{
    public function __construct()
    {
    }

    protected function view($path, $params = array())
    {
        $templatePath = ROOT_PATH.'/template';
        $path = $templatePath.'/'.ltrim($path, '/').'.php';

        if (file_exists($path)) {
            extract($params);

             include($path);
        } else {
            throw  new \Exception($path.' 不存在!');
        }

    }
}