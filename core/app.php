<?php
namespace core;

class App
{
    public function __construct()
    {

    }

    public function run()
    {
        (new Router())->dispatch();
    }
}