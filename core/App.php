<?php

namespace core;

class App
{
    public function __construct()
    {

    }

    public function run()
    {
        if (DEBUG) {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
        }
        Config::Load();
        (new Router())->dispatch();
    }
}