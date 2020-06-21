<?php
declare(strict_types=1);

namespace App\Logic\Admin;


use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Service\Admin\MenuService;
use App\Service\Admin\RoleService;
use App\Utils\Common;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class RoleLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var RoleService
     */
    public $service;

    /**
     * @Inject()
     * @var MenuService
     */
    public $menuService;

    /**
     * @Inject()
     * @var RoleService
     */
    public $roleService;

    /**
     * 创建角色
     * @param RequestInterface $data
     * @return int|void
     */
    public function store($data)
    {
        $params = [
            'name' => trim($data['name']),
            'desc' => trim($data['desc']),
            'status' => $data['status'],
        ];
        $this->service->condition = ['name' => $params['name']];
        $roleInfo = $this->service->show();
        if (!empty($roleInfo)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '名称已存在');
        }
        $this->service->data = $params;
        $res = $this->service->store();
        if (!$res) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '创建失败');
        }
        return $res;
    }

    /**
     * 更新角色
     * @param $data
     * @return int
     */
    public function update($data)
    {
        $params = [
            'name' => trim($data['name']),
            'desc' => trim($data['desc']),
            'status' => $data['status'],
        ];
        $condition = ['id' => $data['id']];
        $this->service->condition = $condition;
        $roleInfo = $this->service->show();
        if (empty($roleInfo)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '角色不存在');
        }
        $this->service->condition = $condition;
        $this->service->data = $params;
        $res = $this->service->update();
        if (!$res) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '更新失败');
        }
        return $res;
    }

    /**
     * 更新角色权限
     * @param $data
     */
    public function updatePermission($data)
    {
        $condition = ['id' => $data['id']];
        $this->service->condition = $condition;
        $roleInfo = $this->service->show();
        if (empty($roleInfo)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '角色不存在');
        }
        $allMenuList = $this->menuService->multiTableJoinQueryBuilder()->whereIn('id', $data['menu_ids'])->get()->toArray();
        $menuIds = [];
        foreach ($allMenuList as $key => $value) {
            $pathStr = implode(',', explode('-', $value['path']));
            $menuIds[] = $pathStr;
        }
        $menuIds = array_unique(explode(',', implode(',', $menuIds)));
        $this->service->data = ['menu_ids' => implode(',', $menuIds)];
        $this->service->condition = $condition;
        $res = $this->service->update();
        if (!$res) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '更新角色权限失败');
        }
        return $res;
    }

    /**
     * @param $id
     * @return bool|int
     * @throws \Exception
     */
    public function delete($id)
    {
        return $this->service->deleteRole($id);
    }

    /**
     * @param $id
     * @return array
     */
    public function show($id): array
    {
        $this->service->condition = ['id' => $id];
        $roleInfo = $this->service->show();
        if (empty($roleInfo)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '角色不存在');
        }
        $roleInfo['menu_ids'] = explode(',', $roleInfo['menu_ids']);
        $allMenuIds = [];
        $menuIdsList = $this->roleService->getMenuIdsListByRole([$id]);
        $menuList = $this->menuService->getMenuList(2);

        foreach ($menuList as $key => &$value) {
            $allMenuIds[] = $value['id'];
            if (in_array($value['id'], $menuIdsList)) {
                $value['is_choose'] = true; // 是否选择  true:选择 false:不选择
            } else {
                $value['is_choose'] = false;
            }
            $value['check_list'] = [];
            $value['children'] = [];
        }
        $menuList =  Common::generateTree($menuList);
        $roleInfo['menu_list'] = $menuList;
        $roleInfo['all_menu_ids'] = $allMenuIds;
        return $roleInfo;
    }
}