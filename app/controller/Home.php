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
        $comment = (new Comment())->find(62);
        $comment->title = '222';
        $comment->save();
        dump($comment);
        exit;
        $this->view('home/site', compact('title'));
    }
}