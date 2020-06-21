<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property string $name 菜单名称
 * @property int $nav_id 导航ID
 * @property int $parent_id 父ID
 * @property string $target 链接打开方式 默认方式：空 新页面方式： _blank
 * @property string $href 链接
 * @property string $icon icon图标
 * @property int $is_custom icon图标是否自定义
 * @property string $path 层级关系
 * @property int $sort_order 排序t
 * @property int $status 状态 1：正常 0：删除
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $created_at 
 */
class NavigationItem extends Model
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
    protected $table = 'navigation_item';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'nav_id', 'parent_id', 'target', 'href', 'icon', 'is_custom', 'path', 'sort_order', 'status', 'updated_at', 'created_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'nav_id' => 'integer', 'parent_id' => 'integer', 'is_custom' => 'integer', 'sort_order' => 'integer', 'status' => 'integer', 'updated_at' => 'datetime', 'created_at' => 'datetime'];
}