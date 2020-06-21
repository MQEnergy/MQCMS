<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateThemeConfigTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('theme_config', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('theme_name', 64)->nullable(false)->comment('模板名称');
            $table->string('theme_desc', 64)->nullable(false)->comment('')->comment('模板描述');
            $table->string('thumb_url', 128)->nullable(false)->comment('')->comment('缩略图');
            $table->string('version', 16)->nullable(false)->default('1.0.0')->comment('版本号');
            $table->string('language', 16)->nullable(false)->default('zh-CN')->comment('语言');
            $table->string('author', 32)->nullable(false)->default('')->comment('作者名称');
            $table->string('link_url', 64)->nullable(false)->default('')->comment('作者网站');
            $table->unsignedTinyInteger('is_used')->nullable(false)->default(1)->comment('状态 1：使用 0：未使用');
            $table->unsignedTinyInteger('status')->nullable(false)->default(1)->comment('状态 1：正常 0：卸载');
            $table->unsignedBigInteger('updated_at')->nullable();
            $table->unsignedBigInteger('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_config');
    }
}
