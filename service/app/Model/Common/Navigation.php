<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property string $nav_name 导航名称
 * @property string $nav_desc 导航描述
 * @property int $is_main 是否主导航 1：是 0：不是
 * @property int $status 状态 1：正常 0：删除
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $created_at 
 */
class Navigation extends Model
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
    protected $table = 'navigation';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'nav_name', 'nav_desc', 'is_main', 'status', 'updated_at', 'i'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'is_main' => 'integer', 'status' => 'integer', 'updated_at' => 'datetime', 'created_at' => 'datetime'];
}