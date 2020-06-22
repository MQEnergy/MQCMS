<?php
declare(strict_types=1);

namespace App\Logic;

use App\Middleware\BaseAuthMiddleware;
use Hyperf\HttpServer\Contract\RequestInterface;

abstract class AbstractLogic
{
    /**
     * @var
     */
    public $service;

    /**
     * @param int $page
     * @param int $limit
     * @param array $search
     * @return array
     */
    abstract public function index($page=1, $limit=10, $search=[]): array;

    /**
     * @param $condition
     * @return array
     */
    abstract public function show($condition): array;

    /**
     * @param $data
     * @return mixed
     */
    abstract public function store($data);

    /**
     * @param $condition
     * @return mixed
     */
    abstract public function delete($condition);

    /**
     * @param $condition
     * @param $data
     * @return mixed
     */
    abstract public function update($data);

    /**
     * 获取token值
     * @return string
     */
    public function getAuthToken(): string
    {
        return BaseAuthMiddleware::$authToken;
    }

    /**
     * 获取解析后的token数据
     * @return array
     */
    public function getTokenInfo(): array
    {
        return BaseAuthMiddleware::$tokenInfo;
    }

    /**
     * 创建token
     * @param $info
     * @return string
     */
    public function createAuthToken($info, RequestInterface $request): string
    {
        return BaseAuthMiddleware::createAuthToken($info, $request); // TODO: Change the autogenerated stub
    }

    /**
     * @return array
     */
    public function getJwtConfig(RequestInterface $request): array
    {
        return BaseAuthMiddleware::getJwtConfig($request);
    }
}