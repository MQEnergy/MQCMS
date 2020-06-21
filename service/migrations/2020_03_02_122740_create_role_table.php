<?php
/**
 * 角色表
 */
use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64)->nullable(false)->comment('角色名称');
            $table->string('desc', 64)->nullable(false)->default('')->comment('角色描述');
            $table->string('menu_ids', 255)->nullable(false)->default('')->comment('角色菜单ids 逗号分隔 1,2,3,4...');
            $table->unsignedTinyInteger('status')->nullable(false)->default(1)->comment('状态 1：正常 0：停用');
            $table->unsignedBigInteger('created_at')->nullable();
            $table->unsignedBigInteger('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role');
    }
}
