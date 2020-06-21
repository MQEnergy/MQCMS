<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('category')) {
            Schema::create('category', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('cate_name', 128)->nullable(false)->comment('分类名称');
                $table->string('alias_name', 128)->nullable(false)->comment('分类别名');
                $table->string('cate_desc', 128)->nullable(false)->default('')->comment('分类描述');
                $table->unsignedBigInteger('parent_id')->nullable(false)->default(0)->comment('父ID');
                $table->string('seo_title', 128)->nullable(false)->default('')->comment('seo标题');
                $table->string('seo_keyword', 128)->nullable(false)->default('')->comment('seo关键词');
                $table->string('seo_desc', 128)->nullable(false)->default('')->comment('seo描述');
                $table->unsignedInteger('list_template_id')->nullable(false)->comment('列表模版ID');
                $table->unsignedInteger('detail_template_id')->nullable(false)->comment('文章模版ID');
                $table->string('path', 16)->nullable(false)->default('')->comment('层级关系');
                $table->unsignedTinyInteger('sort_order')->nullable(false)->default(50)->comment('排序');
                $table->unsignedTinyInteger('status')->nullable(false)->default(1)->comment('状态 1：正常 0：删除');
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
        Schema::dropIfExists('category');
    }
}
