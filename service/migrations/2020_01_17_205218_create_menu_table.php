<?php
/**
 * 菜单表
 */
use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('menu')) {
            Schema::create('menu', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title', 64)->nullable(false)->comment('菜单名称');
                $table->string('alias_title', 64)->nullable(false)->comment('菜单别名');
                $table->string('desc', 64)->nullable(false)->default('')->comment('菜单描述');
                $table->string('frontend_url', 64)->nullable(false)->default('')->comment('菜单前端URL');
                $table->string('backend_url', 64)->nullable(false)->default('')->comment('菜单后端URL');
                $table->string('custom', 64)->nullable(false)->default('')->comment('菜单样式class');
                $table->unsignedBigInteger('parent_id')->nullable(false)->default(0)->comment('父ID');
                $table->string('path', 32)->nullable(false)->default('')->comment('路径ID 1-2-3-4...');
                $table->unsignedTinyInteger('menu_type')->nullable(false)->default(1)->comment('菜单类型 1：模块 2：操作');
                $table->unsignedTinyInteger('status')->nullable(false)->default(1)->comment('状态 1：正常 0：停用');
                $table->string('header', 16)->nullable(false)->default('')->comment('顶部值');
                $table->unsignedSmallInteger('sort_order')->nullable(false)->default(50)->comment('排序');
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
        Schema::dropIfExists('menu');
    }
}
