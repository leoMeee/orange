<?php
namespace core;


class Controller
{
    public function __construct()
    {
    }

    protected function view($path, $params = array())
    {
        $templatePath = Config::get('app.template_path', ROOT_PATH.'/template');
        $path = rtrim($templatePath, '/').'/'.ltrim($path, '/').'.php';

        if (file_exists($path)) {
            extract($params);

            include($path);
        } else {
            throw  new \Exception($path.' 不存在!');
        }

    }
}