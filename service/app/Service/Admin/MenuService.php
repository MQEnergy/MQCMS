<?php
declare(strict_types=1);

namespace App\Service\Admin;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Service\AdminRoleRelationService;
use App\Utils\Common;

class MenuService extends \App\Service\Common\MenuService
{
    /**
     * 根据用户ID获取菜单列表
     * @param $uid
     * @param int $type 1：排序 2：不排序
     * @return mixed
     */
    public function getMenuListByUid($uid)
    {
        $adminService = new AdminService();
        $adminService->condition = ['id' => $uid, 'status' => 1];
        $adminInfo = $adminService->show();
        if (empty($adminInfo)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '账号不存在或已被限制');
        }
        $adminRoleRelationService = new AdminRoleRelationService();
        $adminRoleRelationService->condition = ['admin_id' => $uid, 'status' => 1];
        $adminRoleRelation = $adminRoleRelationService->multiTableJoinQueryBuilder()->get()->toArray();
        if (empty($adminRoleRelation)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '当前账号没有分配角色');
        }
        $roleIds = [];
        array_walk($adminRoleRelation, function ($item) use (&$roleIds) {
            $roleIds[] = $item['role_id'];
        });
        $roleService = new RoleService();
        $menuIdsList = $roleService->getMenuIdsListByRole($roleIds);
        $allMenuList = $this->getMenuListByIds($menuIdsList);
        $accessList = [];
        $menusList = [];
        foreach ($allMenuList as $key => $value) {
            if ($value['menu_type'] == 2) {
                $accessList[] = $value['backend_url'];
            }
            if ($value['menu_type'] == 1) {
                $menusList[] = $value;
            }
        }
        return [
            'menu_list' => Common::generateTree($menusList),
            'access_list' => $accessList
        ];
    }

    /**
     * 获取菜单列表
     * @param int $type 1: children排序 2：不排序 3：一维排序
     * @param string $menu_type 空: 获取所有菜单 1：获取模块 2：获取操作
     * @return array
     */
    public function getMenuList(int $type=1, $menu_type='')
    {
        $query = $this->multiTableJoinQueryBuilder();
        if ($menu_type != '' && in_array($menu_type, [1, 2])) {
            $query = $query->where(['menu_type' => $menu_type]);
        }
        $menuList = $query->get()->toArray();
        foreach ($menuList as $key => &$value) {
            $value['created_at'] = date('Y-m-d H:i:s', (int) $value['created_at']);
            $value['updated_at'] = date('Y-m-d H:i:s', (int) $value['updated_at']);
        }
        switch ($type) {
            case 1:
                return Common::g($menuList);
                break;
            case 2:
                return $menuList;
                break;
            case 3:
                return Common::sonTree($menuList, 'title');
                break;
            default:
                throw new BusinessException(ErrorCode::BAD_REQUEST, '参数错误');
                break;
        }
    }

    /**
     * 通过菜单id获取菜单列表
     * @param array $menu_ids
     * @param int $type 1: 排序 2：不排序
     * @return array
     */
    public function getMenuListByIds(array $menu_ids)
    {
        $this->select = ['id', 'title', 'alias_title', 'parent_id', 'frontend_url', 'backend_url', 'custom', 'menu_type', 'header'];
        $this->condition = ['status' => 1];
        $this->orderBy = 'sort_order ASC, id DESC';
        $menuList = $this->multiTableJoinQueryBuilder()->whereIn('id', $menu_ids)->get()->toArray();
        foreach ($menuList as $key => &$value) {
            $value['name'] = $value['alias_title'];
            $value['path'] = $value['frontend_url'];
        }
        return $menuList;
    }

    /**
     * 批量删除菜单
     * @param $id
     * @return bool
     */
    public function deleteMenuList($id)
    {
        $this->condition = ['id' => $id];
        $menuInfo = $this->show();
        if (empty($menuInfo)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '菜单不存在');
        }
        $idsArr = explode('-', $menuInfo['path']);
        $currentKey = array_search($id, $idsArr);
        foreach ($idsArr as $key => &$value) {
            if ($key < $currentKey) {
                unset($value);
            }
        }
        if (empty($idsArr)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '菜单不存在');
        }
        $res = $this->multiTableJoinQueryBuilder()->whereIn('id', $idsArr)->delete();
        if (!$res) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '删除失败');
        }
        return true;
    }

    /**
     * 更新菜单状态
     * @param $id
     * @param $status
     * @return bool
     */
    public function updateStatus($id, $status)
    {
        $this->condition = ['id' => $id];
        $menuInfo = $this->multiTableJoinQueryBuilder()->first();
        if (empty($menuInfo)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '菜单不存在');
        }
        $menuInfo->status = $status;
        if (!$menuInfo->saved()) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '更新失败');
        }
        return true;
    }
}
