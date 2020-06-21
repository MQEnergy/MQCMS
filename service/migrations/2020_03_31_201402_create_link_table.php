<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateLinkTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('link', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('link_name', 32)->nullable(false)->comment('链接名称');
            $table->string('link_desc', 64)->nullable(false)->default('')->comment('链接描述');
            $table->string('link_url')->nullable(false)->default('')->comment('链接地址');
            $table->string('attach_url')->nullable(false)->default('')->comment('链接图片');
            $table->unsignedTinyInteger('target')->nullable(false)->default(1)->comment('链接打开方式 1：_blank 2: _self ...');
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
        Schema::dropIfExists('link');
    }
}
