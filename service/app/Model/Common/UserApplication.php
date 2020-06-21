<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property int $user_id 用户id
 * @property string $app_name 应用名称
 * @property string $app_package_name 应用包名
 * @property string $app_package_path 应用包安装路径
 * @property string $app_package_table 应用包数据表名称 表1,表2,表3....
 * @property string $app_logo 应用logo
 * @property string $app_desc 应用描述
 * @property string $app_intro 应用简介
 * @property string $app_link 应用官网
 * @property string $app_type 应用类型 1：组件 2：应用
 * @property string $app_version 应用版本
 * @property string $app_hash 应用hash值
 * @property int $status 状态 1：正常 0：禁用
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class UserApplication extends Model
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
    protected $table = 'user_application';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'app_name', 'app_package_name', 'app_package_path', 'app_package_table', 'app_logo', 'app_desc', 'app_intro', 'app_link', 'app_type', 'app_version', 'app_hash', 'status', 'created_at', 'updated_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}