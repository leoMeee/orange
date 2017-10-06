<?php
namespace app\controller;


use app\model\Comment;
use core\Config;
use core\Controller;

class Home extends Controller
{
    public function site()
    {
        $model = new Comment();
        $result = $model->all();
        $title = 'Home';
        $this->view('home/site', compact('title','result'));
    }
}