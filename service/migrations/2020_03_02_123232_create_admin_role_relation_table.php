<?php
/**
 * 用户角色关联表
 */
use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAdminRoleRelationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_role_relation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('admin_id')->nullable(false)->comment('管理员ID');
            $table->unsignedInteger('role_id')->nullable(false)->comment('角色ID');
            $table->unsignedTinyInteger('status')->nullable(false)->default(1)->comment('状态 1：正常 0：停用');
            $table->unsignedBigInteger('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_role_relation');
    }
}
