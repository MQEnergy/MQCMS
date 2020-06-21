<?php
/**
 * 后台管理员表
 */
use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('admin')) {
            Schema::create('admin', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('uuid', 32)->nullable(false)->comment('唯一id号');
                $table->string('account', 64)->nullable(false)->comment('账号');
                $table->string('password', 64)->nullable(false)->default('')->comment('密码');
                $table->string('phone', 16)->nullable(false)->default('')->comment('手机号');
                $table->string('avatar', 128)->nullable(false)->default('')->comment('头像');
                $table->string('salt', 32)->nullable(false)->comment('密码');
                $table->string('real_name', 64)->nullable(false)->default('')->comment('真实姓名');
                $table->unsignedBigInteger('register_time')->nullable(false)->comment('注册时间');
                $table->string('register_ip', 32)->nullable(false)->comment('注册ip');
                $table->unsignedBigInteger('login_time')->nullable(false)->comment('登录时间');
                $table->string('login_ip', 32)->nullable(false)->comment('登录ip');
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
        Schema::dropIfExists('admin');
    }
}
