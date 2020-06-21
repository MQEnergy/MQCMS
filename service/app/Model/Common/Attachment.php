<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property int $user_id 附件上传的用户id
 * @property string $attach_name 附件新名称
 * @property string $attach_origin_name 附件原名称
 * @property string $attach_url 附件地址
 * @property int $attach_type 附件类型 1：图片 2：视频 3：文件
 * @property string $attach_minetype 附件mine类型
 * @property string $attach_extension 附件后缀名
 * @property string $attach_size 附件大小
 * @property int $status 状态 1：正常 0：删除
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Attachment extends Model
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
    protected $table = 'attachment';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'attach_name', 'attach_origin_name', 'attach_url', 'attach_type', 'attach_minetype', 'attach_extension', 'attach_size', 'status', 'created_at', 'updated_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'attach_type' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}