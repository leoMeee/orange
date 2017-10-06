<?php
namespace core;

class App
{
    public function __construct()
    {

    }

    public function run()
    {
        Config::Load();
        (new Router())->dispatch();
    }
}