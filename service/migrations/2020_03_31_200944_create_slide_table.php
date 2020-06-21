<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSlideTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('slide', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slide_name', 32)->nullable(false)->comment('分类名称');
            $table->string('slide_desc', 64)->nullable(false)->default('')->comment('描述');
            $table->string('attach_urls')->nullable(false)->default('')->comment('附件urls [url1, url2, ...]');
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
        Schema::dropIfExists('slide');
    }
}
