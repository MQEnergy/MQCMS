<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property string $uuid 唯一id号
 * @property string $user_name 用户名
 * @property string $nick_name 昵称
 * @property string $real_name 真实姓名
 * @property string $phone 手机号
 * @property string $avatar 头像
 * @property string $password 密码
 * @property string $salt 密码
 * @property int $status 状态 1：正常 2：禁用
 * @property string $register_time 注册时间
 * @property string $register_ip 注册ip
 * @property string $login_time 登录时间
 * @property string $login_ip 登录ip
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class User extends Model
{
    /**
     * @var string
     */
    protected $dateFormat = 'U';
    /**
     * @var bool
     */
    public $timestamps = true;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'uuid', 'user_name', 'nick_name', 'real_name', 'phone', 'avatar', 'password', 'salt', 'status', 'register_time', 'register_ip', 'login_time', 'login_ip', 'created_at', 'updated_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}