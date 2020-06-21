<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUploadSettingTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('upload_setting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('multi_num')->nullable(false)->default(5)->comment('最大同时上传数量');
            $table->unsignedInteger('chunk_size')->nullable(false)->default(512)->comment('文件分块上传分块大小');
            $table->string('img_file_type', 64)->nullable(false)->default('jpg,jpeg,png,gif,bmp4')->comment('图片文件格式');
            $table->unsignedInteger('img_file_size')->nullable(false)->default(10240)->comment('图片文件大小');
            $table->string('video_file_type', 64)->nullable(false)->default('mp4,avi,wmv,rm,rmvb,mkv')->comment('视频文件格式');
            $table->unsignedInteger('video_file_size')->nullable(false)->default(10240)->comment('视频文件大小');
            $table->string('audio_file_type', 64)->nullable(false)->default('mp3,wma,wav')->comment('音频文件格式');
            $table->unsignedInteger('audio_file_size')->nullable(false)->default(10240)->comment('音频文件大小');
            $table->string('attach_file_type', 64)->nullable(false)->default('txt,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar')->comment('附件文件格式');
            $table->unsignedInteger('attach_file_size')->nullable(false)->default(10240)->comment('附件文件大小');
            $table->unsignedBigInteger('updated_at')->nullable();
            $table->unsignedBigInteger('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload_setting');
    }
}
