<?php
declare(strict_types=1);

namespace App\Model\Entity;

class AdminRoleRelation extends \App\Model\Common\AdminRoleRelation
{
    public function adminList()
    {
        return $this->hasMany(Admin::class, 'id', 'admin_id');
    }
}