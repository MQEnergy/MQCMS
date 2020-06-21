<?php
/**
 * 附件表
 */
use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('attachment')) {
            Schema::create('attachment', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id')->nullable(false)->default(0)->comment('附件上传的用户id');
                $table->string('attach_name', 64)->nullable(false)->default('')->comment('附件新名称');
                $table->string('attach_origin_name', 64)->nullable(false)->default('')->comment('附件原名称');
                $table->string('attach_url', 255)->nullable(false)->comment('附件地址');
                $table->unsignedTinyInteger('attach_type')->nullable(false)->default(1)->comment('附件类型 1：图片 2：视频 3：文件');
                $table->string('attach_minetype', 16)->nullable(false)->default('')->comment('附件mine类型');
                $table->string('attach_extension', 16)->nullable(false)->default('')->comment('附件后缀名');
                $table->string('attach_size', 32)->nullable(false)->default('')->comment('附件大小');
                $table->unsignedTinyInteger('status')->nullable(false)->default(1)->comment('状态 1：正常 0：删除');
                $table->unsignedBigInteger('created_at')->nullable();
                $table->unsignedBigInteger('updated_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment');
    }
}
