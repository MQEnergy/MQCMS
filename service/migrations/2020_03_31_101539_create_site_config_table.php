<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSiteConfigTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_config', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('site_name', 64)->nullable(false)->comment('网站名称');
            $table->integer('theme_id')->nullable(false)->comment('后台风格');
            $table->string('icp_no', 32)->nullable(false)->default('')->comment('icp备案');
            $table->string('safe_record', 32)->nullable(false)->default('')->comment('公网安备');
            $table->string('site_email', 64)->nullable(false)->default('')->comment('站长邮箱');
            $table->string('site_analytics')->nullable(false)->default('')->comment('统计代码');
            $table->string('seo_title', 128)->nullable(false)->default('')->comment('seo标题');
            $table->string('seo_keyword')->nullable(false)->default('')->comment('seo关键词');
            $table->string('seo_description')->nullable(false)->default('')->comment('seo描述');
            $table->string('cdn_url')->nullable(false)->default('')->comment('静态资源cdn地址');
            $table->unsignedBigInteger('updated_at')->nullable();
            $table->unsignedBigInteger('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_config');
    }
}
