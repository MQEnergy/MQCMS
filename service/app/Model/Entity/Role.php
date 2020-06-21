<?php
declare(strict_types=1);

namespace App\Model\Entity;

class Role extends \App\Model\Common\Role
{
    public function adminIds()
    {
        return $this->hasMany(AdminRoleRelation::class, 'role_id', 'id')->with(['adminList' => function ($query) {
            return $query->select(['id', 'account']);
        }]);
    }
}