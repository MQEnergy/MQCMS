<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Common\UserApplication;
use App\Model\Common\UserFavorite;
use App\Model\Common\UserInfo;

class User extends \App\Model\Common\User
{
    /**
     * @return \Hyperf\Database\Model\Relations\HasOne
     */
    public function userInfo()
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'id');
    }

    /**
     * @return \Hyperf\Database\Model\Relations\HasMany
     */
    public function userApplication()
    {
        return $this->hasMany(UserApplication::class, 'user_id', 'id');
    }

    /**
     * @return \Hyperf\Database\Model\Relations\HasMany
     */
    public function userFavorite()
    {
        return $this->hasMany(UserFavorite::class, 'user_id', 'id');
    }

    /**
     * @return \Hyperf\Database\Model\Relations\HasMany
     */
    public function postList()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    /**
     * @return \Hyperf\Database\Model\Relations\HasMany
     */
    public function tagInfo()
    {
        return $this->hasMany(Tag::class, 'first_create_user_id', 'id');
    }
}