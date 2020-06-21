<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property int $first_create_user_id 第一个创建的人的用户id
 * @property string $tag_name 标签名称
 * @property string $tag_title 标签标题（seo）
 * @property string $tag_desc 标签描述（seo）
 * @property string $tag_keyword 标签关键词（seo）
 * @property int $is_hot 是否热门 0：正常 1：热门
 * @property int $tag_type 类型 1：系统创建2：用户创建
 * @property int $status 状态 1：正常 0：禁用（删除）
 * @property int $used_count 被使用的次数
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Tag extends Model
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
    protected $table = 'tag';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'first_create_user_id', 'tag_name', 'tag_title', 'tag_desc', 'tag_keyword', 'is_hot', 'tag_type', 'status', 'used_count', 'created_at', 'updated_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'first_create_user_id' => 'integer', 'is_hot' => 'integer', 'tag_type' => 'integer', 'status' => 'integer', 'used_count' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}