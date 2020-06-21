<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Common\TagPostRelation;

class Post extends \App\Model\Common\Post
{
    public function tagIds()
    {
        return $this->hasMany(TagPostRelation::class, 'post_id', 'id');
    }

    public function userInfo()
    {
        return $this->hasOne(User::class, 'id', 'member_id');
    }

    public function cateInfo()
    {
        return $this->hasOne(Category::class, 'id', 'cate_id');
    }

    public function adminInfo()
    {
        return $this->hasOne(Admin::class, 'id', 'member_id');
    }
}