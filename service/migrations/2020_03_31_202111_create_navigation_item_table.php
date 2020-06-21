<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateNavigationItemTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('navigation_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64)->nullable(false)->default('')->comment('菜单名称');
            $table->unsignedBigInteger('nav_id')->nullable(false)->comment('导航ID');
            $table->unsignedBigInteger('parent_id')->nullable(false)->default(0)->comment('父ID');
            $table->string('target', 8)->nullable(false)->default('')->comment('链接打开方式 默认方式：空 新页面方式： _blank');
            $table->string('href')->nullable(false)->default('')->comment('链接');
            $table->string('icon', 16)->nullable(false)->default('')->comment('icon图标');
            $table->unsignedTinyInteger('is_custom')->nullable(false)->default(0)->comment('图标是否自定义 1：是（iconfont） 0：不是(iview自带)');
            $table->string('path', 16)->nullable(false)->default('')->comment('层级关系');
            $table->unsignedInteger('sort_order')->nullable(false)->default(100)->comment('排序');
            $table->unsignedTinyInteger('status')->nullable(false)->default(1)->comment('状态 1：正常 0：删除');
            $table->unsignedBigInteger('updated_at')->nullable();
            $table->unsignedBigInteger('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigation_item');
    }
}
