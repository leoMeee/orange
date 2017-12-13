<?php

namespace app\model;

use core\Model;

/**
 * Class Comment
 * @package app\model
 *
 * @property int $id
 * @property string $title
 * @property string $content
 */
class Comment extends Model
{
    protected $table = 'comments';
}