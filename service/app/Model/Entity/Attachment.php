<?php
declare(strict_types=1);

namespace App\Model\Entity;

class Attachment extends \App\Model\Common\Attachment
{
    public function userInfo()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}