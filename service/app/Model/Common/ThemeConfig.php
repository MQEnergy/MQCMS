<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property string $theme_name 模板名称
 * @property string $theme_desc 模板描述
 * @property string $thumb_url 缩略图
 * @property string $version 版本号
 * @property string $language 语言
 * @property string $author 作者名称
 * @property string $link_url 作者网站
 * @property int $is_used 状态 1：使用 0：未使用
 * @property int $status 状态 1：正常 0：卸载
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $created_at 
 */
class ThemeConfig extends Model
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
    protected $table = 'theme_config';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'theme_name', 'theme_desc', 'thumb_url', 'version', 'language', 'author', 'link_url', 'is_used', 'status', 'updated_at', 'created_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'is_used' => 'integer', 'status' => 'integer', 'updated_at' => 'datetime', 'created_at' => 'datetime'];
}