<?php

namespace Quiz\Controllers;

class IndexController
{
    public function indexAction()
    {
        echo 'ok';
    }
    public function handleCall(string $action)
    {
        echo static::$action();
    }
}