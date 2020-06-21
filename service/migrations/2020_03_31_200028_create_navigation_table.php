<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateNavigationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('navigation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nav_name', 32)->nullable(false)->comment('导航名称');
            $table->string('nav_desc', 64)->nullable(false)->default('')->comment('导航描述');
            $table->unsignedTinyInteger('is_main')->nullable(false)->default(0)->comment('是否主导航 1：是 0：不是');
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
        Schema::dropIfExists('navigation');
    }
}
