<?php
namespace app\controller;


use app\model\Comment;
use core\Controller;

class Home extends Controller
{
    public function site()
    {
        $model = new Comment();
        $model->add(['title'=>'你好','content'=>'呵呵']);
        $result = $model->all();

        $title = 'Home';
        $this->view('home/site', compact('title','result'));
    }
}