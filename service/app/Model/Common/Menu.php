<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property string $title 菜单名称
 * @property string $alias_title 菜单别名
 * @property string $desc 菜单描述
 * @property string $frontend_url 菜单前端URL
 * @property string $backend_url 菜单后端URL
 * @property string $custom 菜单样式class
 * @property int $parent_id 父ID
 * @property string $path 路径ID 1-2-3-4...
 * @property int $menu_type 菜单类型 1：模块 2：操作
 * @property int $status 状态 1：正常 0：停用
 * @property string $header 顶部值
 * @property int $sort_order 排序
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Menu extends Model
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
    protected $table = 'menu';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'title', 'alias_title', 'desc', 'frontend_url', 'backend_url', 'custom', 'parent_id', 'path', 'menu_type', 'status', 'header', 'sort_order', 'created_at', 'updated_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'parent_id' => 'integer', 'menu_type' => 'integer', 'status' => 'integer', 'sort_order' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}