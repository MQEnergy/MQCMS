<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property int $multi_num 最大同时上传数量
 * @property int $chunk_size 文件分块上传分块大小
 * @property string $img_file_type 图片文件格式
 * @property int $img_file_size 图片文件大小
 * @property string $video_file_type 视频文件格式
 * @property int $video_file_size 视频文件大小
 * @property string $audio_file_type 音频文件格式
 * @property int $audio_file_size 音频文件大小
 * @property string $attach_file_type 附件文件格式
 * @property int $attach_file_size 附件文件大小
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $created_at 
 */
class UploadSetting extends Model
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
    protected $table = 'upload_setting';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'multi_num', 'chunk_size', 'img_file_type', 'img_file_size', 'video_file_type', 'video_file_size', 'audio_file_type', 'audio_file_size', 'attach_file_type', 'attach_file_size', 'updated_at', 'created_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'multi_num' => 'integer', 'chunk_size' => 'integer', 'img_file_size' => 'integer', 'video_file_size' => 'integer', 'audio_file_size' => 'integer', 'attach_file_size' => 'integer', 'updated_at' => 'datetime', 'created_at' => 'datetime'];
}