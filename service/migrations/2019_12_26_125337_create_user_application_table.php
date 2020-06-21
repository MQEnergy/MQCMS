<?php
/**
 * 用户安装应用表
 */
use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserApplicationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('user_application')) {
            Schema::create('user_application', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('user_id')->nullable(false)->comment('用户id');
                $table->string('app_name', 64)->nullable(false)->comment('应用名称');
                $table->string('app_package_name', 64)->nullable(false)->comment('应用包名');
                $table->string('app_package_path', 128)->nullable(false)->comment('应用包安装路径');
                $table->string('app_package_table', 128)->nullable(false)->comment('应用包数据表名称 表1,表2,表3....');
                $table->string('app_logo', 64)->nullable(false)->comment('应用logo');
                $table->string('app_desc', 128)->nullable(false)->default('')->comment('应用描述');
                $table->string('app_intro', 255)->nullable(false)->default('')->comment('应用简介');
                $table->string('app_link', 64)->nullable(false)->default('')->comment('应用官网');
                $table->string('app_type', 64)->nullable(false)->default('')->comment('应用类型 1：组件 2：应用');
                $table->string('app_version', 16)->nullable(false)->comment('应用版本');
                $table->string('app_hash', 64)->nullable(false)->comment('应用hash值');
                $table->unsignedTinyInteger('status')->nullable(false)->default(1)->comment('状态 1：正常 0：禁用');
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
        Schema::dropIfExists('user_application');
    }
}
