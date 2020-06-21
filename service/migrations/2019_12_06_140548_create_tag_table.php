<?php
/**
 * 标签表
 */
use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateTagTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('tag')) {
            Schema::create('tag', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('first_create_user_id')->nullable(false)->comment('第一个创建的人的用户id');
                $table->string('tag_name', 64)->nullable(false)->comment('标签名称');
                $table->string('tag_title', 64)->nullable(false)->comment('标签标题（seo）');
                $table->string('tag_desc', 128)->nullable(false)->comment('标签描述（seo）');
                $table->string('tag_keyword', 128)->nullable(false)->comment('标签关键词（seo）');
                $table->unsignedTinyInteger('is_hot')->nullable(false)->default(0)->comment('是否热门 0：正常 1：热门');
                $table->unsignedTinyInteger('tag_type')->nullable(false)->default(1)->comment('类型 1：系统创建2：用户创建');
                $table->unsignedTinyInteger('status')->nullable(false)->default(1)->comment('状态 1：正常 0：禁用（删除）');
                $table->unsignedInteger('used_count')->nullable(false)->default(1)->comment('被使用的次数');
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
        Schema::dropIfExists('tag');
    }
}
