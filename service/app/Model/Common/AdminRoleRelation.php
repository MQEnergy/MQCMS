<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property int $admin_id 管理员ID
 * @property int $role_id 角色ID
 * @property int $status 状态 1：正常 0：停用
 * @property \Carbon\Carbon $created_at 
 */
class AdminRoleRelation extends Model
{
    /**
     * @var string
     */
    protected $dateFormat = 'U';
    /**
     * @var bool
     */
    public $timestamps = true;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_role_relation';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'admin_id', 'role_id', 'status', 'created_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'admin_id' => 'integer', 'role_id' => 'integer', 'status' => 'integer', 'created_at' => 'datetime'];
}