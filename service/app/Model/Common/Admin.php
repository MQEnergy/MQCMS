<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property string $uuid 唯一id号
 * @property string $account 账号
 * @property string $password 密码
 * @property string $phone 手机号
 * @property string $avatar 头像
 * @property string $salt 密码
 * @property string $real_name 真实姓名
 * @property int $register_time 注册时间
 * @property string $register_ip 注册ip
 * @property int $login_time 登录时间
 * @property string $login_ip 登录ip
 * @property int $status 状态 1：正常 0：禁用
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Admin extends Model
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
    protected $table = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'uuid', 'account', 'password', 'phone', 'avatar', 'salt', 'real_name', 'register_time', 'register_ip', 'login_time', 'login_ip', 'status', 'created_at', 'updated_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'register_time' => 'integer', 'login_time' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}