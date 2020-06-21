<?php
declare(strict_types=1);

namespace App\Logic\Admin;

use App\Service\Admin\AuthService;
use App\Utils\JWT;
use App\Utils\Redis;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class AuthLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var AuthService
     */
    public $service;

    /**
     * @param $data
     * @param RequestInterface $request
     * @return array
     * @throws \Exception
     */
    public function register($data, RequestInterface $request)
    {
        list($lastInsertId, $uuid) = $this->service->register(trim($data['account']), trim($data['phone']), $data['password'], $data['ip']);

        $token = $this->createAuthToken(['id' => $lastInsertId, 'uuid' => $uuid], $request);
        return [
            'token' => $token,
            'expire_time' => JWT::$leeway,
            'uuid' => $uuid,
            'info' => [
                'name' => $data['account'],
                'avatar' => '',
                'access' => []
            ]
        ];
    }

    /**
     * @param RequestInterface $request
     * @return \Hyperf\Database\Model\Model|\Hyperf\Database\Query\Builder|object|null
     */
    public function login($data, RequestInterface $request)
    {
        $adminInfo = $this->service->login(trim($data['account']), $data['password']);

        $token = $this->createAuthToken(['id' => $adminInfo['id'], 'uuid' => $adminInfo['uuid']], $request);
        Redis::getContainer()->set('admin:token:' . $adminInfo['uuid'], $token);

        return [
            'token' => $token,
            'expire_time' => JWT::$leeway,
            'uuid' => $adminInfo['uuid'],
            'info' => [
                'name' => $data['account'],
                'avatar' => $adminInfo['avatar'],
                'access' => []
            ]
        ];
    }
}