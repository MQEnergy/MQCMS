<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property string $cate_name 分类名称
 * @property string $alias_name 分类别名
 * @property string $cate_desc 分类描述
 * @property int $parent_id 父ID
 * @property string $seo_title seo标题
 * @property string $seo_keyword seo关键词
 * @property string $seo_desc seo描述
 * @property int $list_template_id 列表模版ID
 * @property int $detail_template_id 文章模版ID
 * @property string $path 层级关系
 * @property int $status 状态 1：正常 0：删除
 * @property int $sort_order 排序
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Category extends Model
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
    protected $table = 'category';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'cate_name', 'alias_name', 'cate_desc', 'parent_id', 'seo_title', 'seo_keyword', 'seo_desc', 'list_template_id', 'detail_template_id', 'path', 'status', 'sort_order', 'created_at', 'updated_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'parent_id' => 'integer', 'list_template_id' => 'integer', 'detail_template_id' => 'integer', 'status' => 'integer', 'sort_order' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}