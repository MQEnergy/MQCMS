<?php
declare(strict_types=1);

namespace App\Logic\Admin;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Service\Admin\MenuService;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class MenuLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var MenuService
     */
    public $service;

    /**
     * 获取菜单列表
     * @param RequestInterface $request
     * @return array
     */
    public function getMenuList($type, $menu_type)
    {
        return $this->service->getMenuList((int) $type, $menu_type);
    }

    /**
     * 更新菜单
     * @param RequestInterface $request
     * @return bool|int
     */
    public function update($data)
    {
        $post = [
            'id' => $data['id'],
            'title' => trim($data['title']),
            'alias_title' => trim($data['alias_title']),
            'menu_type' => $data['menu_type'],
            'status' => $data['status'],
            'sort_order' => $data['sort_order'],
        ];
        return $this->saveMenuInfo($post);
    }

    /**
     * 新建菜单
     * @param RequestInterface $request
     * @return bool|int
     */
    public function store($data)
    {
        $post = [
            'title' => trim($data['title']),
            'alias_title' => trim($data['alias_title']),
            'parent_id' => $data['parent_id'],
            'menu_type' => $data['menu_type'],
            'status' => $data['status'],
            'sort_order' => $data['sort_order'],
        ];
        return $this->saveMenuInfo($post);
    }

    /**
     * 删除菜单
     * @param RequestInterface $request
     * @return bool|int
     */
    public function delete($id)
    {
        return $this->service->deleteMenuList($id);
    }

    /**
     * 更新菜单状态
     * @param RequestInterface $request
     * @return bool
     */
    public function updateStatus($id, $status)
    {
        return $this->service->updateStatus($id, $status);
    }

    /**
     * 更新编辑菜单
     * @param $data
     * @return bool
     */
    public function saveMenuInfo($data)
    {
        $id = isset($data['id']) ? $data['id'] : '';
        if ($id) {
            $this->service->condition = ['id' => $id];
            $menuInfo = $this->service->multiTableJoinQueryBuilder()->first();
            if (!$menuInfo) {
                $menuInfo = new $this->service->model;
            }
        } else {
            $this->service->condition = ['alias_title' => $data['alias_title']];
            $menuInfo = $this->service->multiTableJoinQueryBuilder()->first();
            if ($menuInfo) {
                throw new BusinessException(ErrorCode::BAD_REQUEST, '菜单别名不能重复');
            }
            $menuInfo = new $this->service->model;
        }
        $menuInfo->title         = $data['title'];
        $menuInfo->alias_title   = $data['alias_title'];
        $menuInfo->desc          = $data['desc'];
        $menuInfo->frontend_url  = isset($data['frontend_url']) ? $data['frontend_url'] : '';
        $menuInfo->backend_url   = $data['backend_url'];
        $menuInfo->custom        = $data['custom'];
        $menuInfo->parent_id     = $data['parent_id'];
        $menuInfo->menu_type     = $data['menu_type'];
        $menuInfo->status        = $data['status'];
        $menuInfo->header        = $data['header'];
        $menuInfo->sort_order    = $data['sort_order'];

        Db::beginTransaction();
        try {
            if (!$menuInfo->save()) {
                throw new BusinessException(ErrorCode::BAD_REQUEST, '保存失败：10000');
            }
            $id = $menuInfo->id;
            $this->service->condition = ['id' => $menuInfo->parent_id];
            $parentMenuInfo = $this->service->show();
            $path = $parentMenuInfo ? $parentMenuInfo['path'] . '-' : '';

            $menuInfo->path = $data['parent_id'] == 0 ? $id : $path . $id;
            if (!$menuInfo->save()) {
                throw new BusinessException(ErrorCode::BAD_REQUEST, '保存失败：10001');
            }
            Db::commit();
            return true;

        } catch (\Exception $e) {
            Db::rollBack();
            throw new BusinessException(ErrorCode::BAD_REQUEST, $e->getMessage());
        }
    }
}