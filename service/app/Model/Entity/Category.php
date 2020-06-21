<?php
declare(strict_types=1);

namespace App\Model\Entity;

class Category extends \App\Model\Common\Category
{
    public function postList()
    {
        return $this->hasMany(Post::class, 'cate_id', 'id');
    }
}