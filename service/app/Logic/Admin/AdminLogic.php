<?php
declare(strict_types=1);

namespace App\Logic\Admin;

use App\Service\Admin\MenuService;
use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Service\Admin\AdminService;
use App\Service\Admin\RoleService;
use App\Service\Common\AdminRoleRelationService;
use App\Utils\Common;
use App\Utils\Redis;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class AdminLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var AdminService
     */
    public $service;

    /**
     * @Inject()
     * @var AdminRoleRelationService
     */
    public $adminRoleRelationService;

    /**
     * @Inject()
     * @var RoleService
     */
    public $roleService;

    /**
     * @param $condition
     * @param $data
     * @return int
     * @throws \Exception
     */
    public function update($data): int
    {
        $salt = Common::generateSalt();
        $this->service->condition = ['id' => $data['id']];

        $this->service->data = [
            'account'       => trim($data['account']),
            'real_name'     => trim($data['real_name']),
            'phone'         => trim($data['phone']),
            'avatar'        => trim($data['avatar']),
            'status'        => $data['status'],
            'salt'          => $salt,
            'password'      => Common::generatePasswordHash(trim($data['password']), $salt),
            'register_time' => time(),
            'register_ip'   => $data['ip'],
        ];
        return $this->service->update();
    }

    /**
     * @param RequestInterface $data
     * @return int|void
     * @throws \Exception
     */
    public function store($data)
    {
        $salt = Common::generateSalt();
        $this->service->data = [
            'uuid'          => Common::generateSnowId(),
            'account'       => trim($data['account']),
            'real_name'     => trim($data['real_name']),
            'phone'         => trim($data['phone']),
            'avatar'        => trim($data['avatar']),
            'status'        => $data['status'],
            'salt'          => $salt,
            'password'      => Common::generatePasswordHash(trim($data['password']), $salt),
            'register_time' => time(),
            'register_ip'   => $data['ip'],
            'login_time'    => time(),
            'login_ip'      => $data['ip'],
        ];
        return $this->service->store();
    }

    /**
     * @param $post
     * @return mixed
     */
    public function module($post)
    {
        return $this->service->getModuleTbleList($post['module']);
    }

    /**
     * 清除缓存
     * @param RequestInterface $request
     * @return array
     */
    public function clearCache($typeArr)
    {
        $data = [];
        if (!function_exists('system')) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '请在php.ini配置中取消禁用system方法');
        }
        array_walk($typeArr, function ($item) use (&$data) {
            switch ($item) {
                case 1:
                    @system('rm -rf ' . BASE_PATH . '/runtime/views/*');
                    $data[] = ['status' => true, 'message' => '网站前端页面缓存清除完毕'];
                    break;
                case 2:
                    Redis::getContainer()->flushDB();
                    $data[] = ['status' => true, 'message' => 'redis缓存清除完毕'];
                    break;
                case 3:
                    @system('rm -rf ' . BASE_PATH . '/runtime/container/proxy');
                    $data[] = ['status' => true, 'message' => '后端代理缓存清除完毕'];
                    break;
                case 4:
                    @system('rm -rf ' . BASE_PATH . '/runtime/logs/*');
                    $data[] = ['status' => true, 'message' => '后端日志清除完毕'];
                    break;
            }
        });
        return $data;
    }

    /**
     * 获取管理员角色列表
     * @param $id
     * @return array
     */
    public function getAdminRoleList($id)
    {
        $this->adminRoleRelationService->condition = ['admin_id' => $id, 'status' => 1];
        $adminRoleList = $this->adminRoleRelationService->multiTableJoinQueryBuilder()->get()->toArray();
        $adminRoleIds = [];
        foreach ($adminRoleList as $key => $value) {
            $adminRoleIds[] = $value['role_id'];
        }
        if (empty($adminRoleIds)) {
            return [];
        }
        $roleList = $this->roleService->multiTableJoinQueryBuilder()
            ->whereIn('id', $adminRoleIds)
            ->get()
            ->toArray();
        return $roleList;
    }

    /**
     * 分配角色
     * @param int $uid
     * @param array $role_ids
     * @return bool
     */
    public function distributeAdminRole(int $uid, array $role_ids)
    {
        $this->service->condition = ['id' => $uid];
        $adminInfo = $this->service->show();
        if (empty($adminInfo)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '用户不存在');
        }
        $condition = ['admin_id' => $uid];
        $this->adminRoleRelationService->condition = $condition;
        $adminRoleRelation = $this->adminRoleRelationService->show();
        $insertData = [];
        array_walk($role_ids, function ($item) use (&$insertData, $uid) {
            $insertData[] = ['admin_id' => $uid, 'role_id' => $item];
        });
        Db::beginTransaction();
        try {
            if (!empty($adminRoleRelation)) {
                $this->adminRoleRelationService->condition = $condition;
                $res = $this->adminRoleRelationService->delete();
                if (!$res) {
                    throw new BusinessException(ErrorCode::BAD_REQUEST, '保存失败:10000');
                }
            }
            if (!empty($insertData)) {
                $res = $this->adminRoleRelationService->multiTableJoinQueryBuilder()->insert($insertData);
                if (!$res) {
                    throw new BusinessException(ErrorCode::BAD_REQUEST, '保存失败:10001');
                }
            }
            Db::commit();
            return true;

        } catch (\Exception $e) {
            Db::rollBack();
            throw new BusinessException((int)$e->getCode(), $e->getMessage());
        }
    }

    /**
     * 根据用户ID获取菜单列表
     * @param RequestInterface $request
     * @return mixed
     */
    public function permission($uid)
    {
        return (new MenuService())->getMenuListByUid($uid);
    }

}