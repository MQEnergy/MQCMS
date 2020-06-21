<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property string $site_name 网站名称
 * @property int $theme_id 后台风格
 * @property string $icp_no icp备案
 * @property string $safe_record 公网安备
 * @property string $site_email 站长邮箱
 * @property string $site_analytics 统计代码
 * @property string $seo_title seo标题
 * @property string $seo_keyword seo关键词
 * @property string $seo_description seo描述
 * @property string $cdn_url 静态资源cdn地址
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $created_at 
 */
class SiteConfig extends Model
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
    protected $table = 'site_config';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'site_name', 'theme_id', 'icp_no', 'safe_record', 'site_email', 'site_analytics', 'seo_title', 'seo_keyword', 'seo_description', 'cdn_url', 'updated_at', 'created_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'theme_id' => 'integer', 'updated_at' => 'datetime', 'created_at' => 'datetime'];
}