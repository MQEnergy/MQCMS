<?php
/**
 * 用户授权表
 */
use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserAuthTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('user_auth')) {
            Schema::create('user_auth', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id')->nullable(false)->comment('用户id');
                $table->string('oauth_id', 64)->nullable(false)->default('')->comment('第三方 uid 、openid 等');
                $table->string('union_id', 64)->nullable(false)->default('')->comment('QQ / 微信同一主体下 Unionid 相同');
                $table->string('auth_type', 16)->nullable(false)->default('')->comment('登录类型 email phone weibo username weixin...');
                $table->string('credential', 16)->nullable(false)->default('')->comment('密码凭证 /access_token (目前更多是存储在缓存里)');
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
        Schema::dropIfExists('user_auth');
    }
}
