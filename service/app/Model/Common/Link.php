<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property string $link_name 链接名称
 * @property string $link_desc 链接描述
 * @property string $link_url 链接地址
 * @property string $attach_url 链接图片
 * @property int $target 链接打开方式 1：_blank 2: _self ...
 * @property int $sort_order 排序
 * @property int $status 状态 1：正常 0：删除
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $created_at 
 */
class Link extends Model
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
    protected $table = 'link';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'link_name', 'link_desc', 'link_url', 'attach_url', 'target', 'sort_order', 'status', 'updated_at', 'created_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'target' => 'integer', 'sort_order' => 'integer', 'status' => 'integer', 'updated_at' => 'datetime', 'created_at' => 'datetime'];
}