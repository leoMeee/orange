<?php

namespace core;

abstract class Object
{
    public function className()
    {
        return get_called_class();
    }
}