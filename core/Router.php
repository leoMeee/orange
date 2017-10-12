<?php

namespace core;


class Router
{
    public function dispatch()
    {
        $urlArray = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));
        $controller = $urlArray[0] ?: $this->getDefaultController();
        $action = $urlArray[1] ?? $this->getDefaultAction();
        $controller = $this->getController($controller);
        $action = $this->getAction($action);

        (new $controller)->$action();
    }

    private function getController($controller)
    {
        $controller = ucwords(strtolower($controller));
        $namespace = 'app\controller';

        return $namespace . '\\' . $controller;
    }

    private function getAction($action)
    {
        return $action;
    }

    private function getDefaultController()
    {
        return ucfirst(Config::get('app.default_controller'));
    }

    private function getDefaultAction()
    {
        return Config::get('app.default_action');
    }
}