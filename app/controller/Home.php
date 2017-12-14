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
        $result = Comment::all();
        dump($result);exit;
        $title = '评论列表';
        $this->view('home/site', compact('title', 'result'));
    }
}