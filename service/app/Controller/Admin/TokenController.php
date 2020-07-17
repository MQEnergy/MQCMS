<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use App\Amqp\Producer\DemoProducer;
use App\Utils\Common;
use App\Utils\Redis;
use Hyperf\Amqp\Producer;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\ApplicationContext;

/**
 * @AutoController()
 * Class TokenController
 * @package App\Controller\Admin
 */
class TokenController extends BaseController
{
    /**
     * 获取token信息
     * @return array|bool|object|string
     */
    public function index(RequestInterface $request)
    {
        return [
            'info' => $this->logic->getTokenInfo(),
            'token' => $this->logic->getAuthToken(),
            'uid' => $request->getAttribute('uid'),
            'uuid' => $request->getAttribute('uuid'),
            'current_action' => Common::getCurrentActionName($request, $this)
        ];
    }

    /**
     * 创建token
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function store(RequestInterface $request)
    {
        $token = $this->logic->createAuthToken([
            'id' => 1,
            'uuid' => 123,
            'name' => 'mqcms',
            'url' => 'http://www.mqcms.net',
            'from_module' => Common::getCurrentPath($request),
            'from_action' => Common::getCurrentActionName($request, $this)
        ], $request);

        Redis::getContainer()->set('admin:token:123', $token);

        return [
            'token' => $token,
            'jwt_config' => $this->logic->getJwtConfig($request),
            'uid' => $request->getAttribute('uid'),
            'uuid' => $request->getAttribute('uuid')
        ];
    }

    /**
     * @param RequestInterface $request
     * @return mixed
     */
    public function producer(RequestInterface $request)
    {
        // $result = [];
        // $producer = ApplicationContext::getContainer()->get(Producer::class);
        // for ($i = 0; $i < 100; $i++) {
        //     $message = new DemoProducer($i);
        //     $result[] = $producer->produce($message);
        // }
        // return $result;
    }
}