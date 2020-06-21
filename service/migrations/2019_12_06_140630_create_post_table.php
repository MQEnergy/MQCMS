<?php
/**
 * 文章表
 */
use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('post')) {
            Schema::create('post', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('member_id')->nullable(false)->comment('发布者id');
                $table->unsignedBigInteger('cate_id')->nullable(false)->comment('分类ID');
                $table->string('post_title', 128)->nullable(false)->comment('标题');
                $table->longText('post_content')->nullable(true)->comment('内容');
                $table->string('post_excerpt', 200)->nullable(false)->default('')->comment('摘要');
                $table->string('post_source', 200)->nullable(false)->default('')->comment('文章来源');
                $table->string('thumb_url', 200)->nullable(false)->default('')->comment('缩略图');
                $table->unsignedInteger('publish_time')->nullable(false)->comment('发布时间');
                $table->string('link_url', 200)->nullable(false)->default('')->comment('标题外链url');
                $table->unsignedTinyInteger('use_link')->nullable(false)->default(0)->comment('是否使用外链 1：使用 0：不使用');
                $table->string('relation_tag_ids', 255)->nullable(false)->default('')->comment('关联标签ids 1,2...');
                $table->string('relation_tags_name', 255)->nullable(false)->default('')->comment('关联标签 标签1,标签2...');
                $table->json('relation_photo_urls')->nullable(true)->comment('关联相册列表');
                $table->string('relation_photo_ids', 64)->nullable(false)->default('')->comment('关联相册附件ids列表1,2,3...');
                $table->json('relation_attach_urls')->nullable(true)->comment('关联附件列表');
                $table->unsignedTinyInteger('status')->nullable(false)->default(1)->comment('状态 1：正常 0：删除');
                $table->unsignedTinyInteger('is_publish')->nullable(false)->default(1)->comment('是否发布 1：发布 0：未发布（草稿）');
                $table->unsignedTinyInteger('is_recommend')->nullable(false)->default(0)->comment('是否推荐 1：推荐 0：正常');
                $table->unsignedTinyInteger('is_top')->nullable(false)->default(0)->comment('是否置顶 1：置顶 0：正常');
                $table->unsignedInteger('template_id')->nullable(false)->default(0)->comment('模板ID');
                $table->unsignedInteger('sort_order')->nullable(false)->default(100)->comment('排序');
                $table->unsignedBigInteger('like_total')->nullable(false)->default(0)->comment('点赞总数');
                $table->unsignedBigInteger('favorite_total')->nullable(false)->default(0)->comment('收藏总数');
                $table->unsignedBigInteger('comment_total')->nullable(false)->default(0)->comment('评论总数');
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
        Schema::dropIfExists('post');
    }
}
