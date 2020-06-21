<?php
declare(strict_types=1);

namespace App\Logic\Admin;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Service\Admin\UserService;
use App\Service\Common\UserInfoService;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class UserLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var UserService
     */
    public $service;

    /**
     * @Inject()
     * @var UserInfoService
     */
    public $userInfoService;

    /**
     * @param RequestInterface $data
     * @return int
     * @throws \Exception
     */
    public function store($data)
    {
        $post = [
            'user_name' => trim($data['user_name']),
            'real_name' => trim($data['real_name']),
            'phone' => trim($data['phone']),
            'status' => $data['status'],
            'ip' => $data['ip'],
        ];
        Db::beginTransaction();
        try{
            $lastInsertId = $this->service->createUserInfo($post);
            if (!$lastInsertId) {
                throw new BusinessException(ErrorCode::BAD_REQUEST, '创建用户失败:10000');
            }
            $this->userInfoService->data = [
                'user_id' => $lastInsertId
            ];
            $res1 = $this->userInfoService->store();
            if (!$res1) {
                throw new BusinessException(ErrorCode::BAD_REQUEST, '创建用户失败:10001');
            }
            Db::commit();
            return true;

        } catch(\Exception $e) {
            Db::rollBack();
            throw new BusinessException((int)$e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param $data
     * @return int
     */
    public function update($data)
    {
        $post = [
            'user_name' => trim($data['user_name']),
            'real_name' => trim($data['real_name']),
            'nick_name' => trim($data['user_name']) . '_' . generate_random_string(6),
            'phone' => trim($data['phone']),
            'status' => $data['status'],
        ];
        $this->service->condition = ['id' => $data['id']];
        $this->service->data = $post;
        return $this->service->update();
    }
}