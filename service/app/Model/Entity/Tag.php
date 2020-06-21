<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Common\TagPostRelation;

class Tag extends \App\Model\Common\Tag
{
    public function postIds()
    {
        return $this->hasMany(TagPostRelation::class, 'tag_id', 'id');
    }
}