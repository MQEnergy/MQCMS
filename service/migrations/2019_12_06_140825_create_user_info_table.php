<?php
/**
 * 用户详情表
 */
use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('user_info')) {
            Schema::create('user_info', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id')->nullable(false)->comment('用户id');
                $table->string('intro', '200')->nullable()->default('')->comment('简介');
                $table->unsignedInteger('like_num')->nullable(false)->default(0)->comment('获赞数');
                $table->unsignedInteger('follow_num')->nullable(false)->default(0)->comment('关注数');
                $table->unsignedInteger('fans_num')->nullable(false)->default(0)->comment('粉丝数');
                $table->unsignedInteger('post_num')->nullable(false)->default(0)->comment('发帖数');
                $table->unsignedInteger('my_like_num')->nullable(false)->default(0)->comment('我点赞数');
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
        Schema::dropIfExists('user_info');
    }
}
