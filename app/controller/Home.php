<?php

namespace app\controller;


use app\model\Comment;
use core\Config;
use core\Controller;
use core\Db;

class Home extends Controller
{
    public function site()
    {
        $model = new Comment();
        $comment = Db::table($model->getTable());
        $result = $comment->where('title','天空')->select();

        $title = 'Home';
        $this->view('home/site', compact('title', 'result'));
    }
}