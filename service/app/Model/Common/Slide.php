<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property string $slide_name 分类名称
 * @property string $slide_desc 描述
 * @property string $attach_urls 附件urls [url1, url2, ...]
 * @property int $status 状态 1：正常 0：删除
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $created_at 
 */
class Slide extends Model
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
    protected $table = 'slide';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'slide_name', 'slide_desc', 'attach_urls', 'status', 'updated_at', 'created_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'status' => 'integer', 'updated_at' => 'datetime', 'created_at' => 'datetime'];
}