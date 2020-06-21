<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property int $user_id 用户id
 * @property string $oauth_id 第三方 uid 、openid 等
 * @property string $union_id QQ / 微信同一主体下 Unionid 相同
 * @property string $auth_type 登录类型 email phone weibo username weixin...
 * @property string $credential 密码凭证 /access_token (目前更多是存储在缓存里)
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class UserAuth extends Model
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
    protected $table = 'user_auth';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'oauth_id', 'union_id', 'auth_type', 'credential', 'created_at', 'updated_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}