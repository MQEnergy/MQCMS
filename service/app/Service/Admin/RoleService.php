<?php
declare(strict_types=1);

namespace App\Service\Admin;


use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Model\Entity\Role;
use App\Service\Common\AdminRoleRelationService;
use App\Utils\Common;
use Hyperf\Di\Annotation\Inject;

class RoleService extends \App\Service\Common\RoleService
{
    /**
     * @Inject()
     * @var Role
     */
    public $model;

    /**
     * 根据用户ID获取角色列表
     * @param $uid
     * @return array
     */
    public function getRoleListByUid($uid)
    {
        $adminRoleRelationService = new AdminRoleRelationService();
        $adminRoleRelationService->select = ['role_id'];
        $adminRoleRelationService->condition = ['admin_id' => $uid];
        $adminRoleRelationList = $adminRoleRelationService->multiTableJoinQueryBuilder()->get()->toArray();
        if (empty($adminRoleRelationList)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '当前用户没有设置角色');
        }
        $roleIdsList = array_column($adminRoleRelationList, 'role_id');
        $roleList = $this->multiTableJoinQueryBuilder()->whereIn('id', $roleIdsList)->get()->toArray();
        return $roleList;
    }

    /**
     * 根据角色获取菜单id列表
     * @param array $role_ids
     * @return array
     */
    public function getMenuIdsListByRole(array $role_ids)
    {
        $menuIdsList = $this->multiTableJoinQueryBuilder()->select(['menu_ids'])->whereIn('id', $role_ids)->get()->toArray();
        $tempMenuIds = [];
        $menuIds = [];
        foreach ($menuIdsList as $key => $value) {
            $tempMenuIds[] = explode(',', $value['menu_ids']);
        }
        foreach ($tempMenuIds as $key => $value) {
            if (is_array($value) && !empty($value)) {
                foreach ($value as $k => $v) {
                    $menuIds[] = $v;
                }
            }
        }
        return array_unique($menuIds);
    }

    /**
     * 更新创建角色
     * @param $data
     * @return bool
     */
    public function saveRoleInfo($data)
    {
        $id = isset($data['id']) ? $data['id'] : '';
        if ($id) {
            $this->condition = ['id' => $data['id']];
            $roleInfo = $this->multiTableJoinQueryBuilder()->first();
            if (!$roleInfo) {
                $roleInfo = $this->model;
            }
        } else {
            $this->condition = ['name' => $data['name']];
            $roleInfo = $this->multiTableJoinQueryBuilder()->first();
            if ($roleInfo) {
                throw new BusinessException(ErrorCode::BAD_REQUEST, '名称已存在');
            }
            $roleInfo = $this->model;
        }
        $roleInfo->name = $data['name'];
        $roleInfo->desc = isset($data['desc']) ? $data['desc'] : '';
        $roleInfo->status = $data['status'];
        if (!$roleInfo->save()) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '保存失败');
        }
        return true;
    }

    /**
     * 删除角色
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function deleteRole($id)
    {
        $this->with = [
            'adminIds' => ['admin_id', 'role_id']
        ];
        $this->condition = ['id' => $id];
        $roleInfo = $this->multiTableJoinQueryBuilder()->first();
        if (!$roleInfo) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '角色不存在');
        }
        $adminIds = $roleInfo->adminIds->toArray();
        if (!empty($adminIds) && !empty($adminIds[0]['admin_list'])) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '该角色有关联管理员，请先删除管理员');
        }
        if (!$roleInfo->delete()) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '删除失败');
        }
        return true;
    }

}