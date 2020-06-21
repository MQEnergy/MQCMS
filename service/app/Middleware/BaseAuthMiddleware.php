<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Utils\Common;
use App\Utils\JWT;
use App\Utils\Redis;
use Hyperf\Utils\Context;
use Psr\Container\ContainerInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BaseAuthMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var HttpResponse
     */

    protected $response;

    /**
     * @var string
     */
    protected $header = 'Authorization';

    /**
     * @var string
     */
    protected $pattern = '/^Bearer\s+(.*?)$/';

    /**
     * @var string
     */
    protected $realm = 'api';

    /**
     * @var string
     */
    public static $authToken = '';

    /**
     * @var array
     */
    public static $tokenInfo = [];

    /**
     * AuthMiddleware constructor.
     * @param ContainerInterface $container
     * @param HttpResponse $response
     * @param RequestInterface $request
     */
    public function __construct(ContainerInterface $container, HttpResponse $response, RequestInterface $request)
    {
        $this->container = $container;
        $this->response = $response;
        $this->request = $request;
    }

    /**
     * get jwt config
     * @param $currentPath
     * @return array
     */
    public static function getJwtConfig(RequestInterface $request)
    {
        $currentPath = Common::getCurrentPath($request);
        return [
            'key' => env('JWT_' . strtoupper($currentPath) . '_KEY', 'mqcms'),
            'id' => env('JWT_' . strtoupper($currentPath) . '_ID', 'api'),
            'exp' => env('JWT_' . strtoupper($currentPath) . '_EXP', '86400'),
            'aud' => env('JWT_' . strtoupper($currentPath) . '_AUD', 'api.mqcms.net'),
            'iss' => env('JWT_' . strtoupper($currentPath) . '_ISS', 'api.mqcms.net')
        ];
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->challenge();
        $header = $request->getHeader($this->header);
        $tokenInfo = $this->authenticate($header);
        if (!$tokenInfo) {
            self::$tokenInfo = [];
            self::$authToken = '';
        }
        $request = $this->withTokenAttributes($tokenInfo, $request);
        Context::set(ServerRequestInterface::class, $request);
        return $handler->handle($request);
    }

    /**
     * @param $tokenInfo
     * @param ServerRequestInterface $request
     * @return ServerRequestInterface
     */
    public function withTokenAttributes($tokenInfo, ServerRequestInterface $request)
    {
        $uid = isset($tokenInfo['sub']->id) ? $tokenInfo['sub']->id : 0;
        $uuid = isset($tokenInfo['sub']->uuid) ? $tokenInfo['sub']->uuid : 0;
        $request = $request->withAttribute('uid', $uid); // 用户id
        $request = $request->withAttribute('uuid', $uuid); // 全局唯一ID

        // 登录互斥判断
        $currentPath = Common::getCurrentPath($this->request);
        $appMutex = env('APP_' . strtoupper($currentPath) . '_MUTEX', true);
        if ($appMutex) {
            $redisOn = env('REDIS_ON', false);
            if ($redisOn) {
                $redisToken = Redis::getContainer()->get(strtolower($currentPath) . ':token:' . $uuid);
                if ($redisToken && $redisToken !== self::$authToken) {
                    throw new BusinessException(ErrorCode::UNAUTHORIZED, '您已在其他设备登录');
                }
            }
        }
        return $request;
    }

    /**
     * setHeader
     */
    public function challenge()
    {
        $response = $this->response->withHeader('WWW-Authenticate', "Bearer realm=\"{$this->realm}\"");
        Context::set(ResponseInterface::class, $response);
    }

    /**
     * 验证token 必须加Bearer 或者其他头部
     * @param $header
     * @return bool|null
     */
    public function authenticate($header)
    {
        if (!empty($header) && $header[0] !== null) {
            if ($this->pattern === null) {
                return null;
            }
            if (preg_match($this->pattern, $header[0], $matches)) {
                self::$authToken = $matches[1];
                return $this->getAuthTokenInfo();
            }
            return null;
        }
        return null;
    }

    /**
     * 验证token有效性并获取token值
     * @param RequestInterface $request
     * @return array|bool|object|string
     */
    public function getAuthTokenInfo()
    {
        $config = self::getJwtConfig($this->request);
        self::$tokenInfo = JWT::getTokenInfo(self::$authToken, $config);
        if (self::$tokenInfo['exp'] - time() > $config['exp']) {
            throw new BusinessException(ErrorCode::UNAUTHORIZED, 'Expired token');
        }
        return self::$tokenInfo;
    }

    /**
     * 创建token
     * @param $info
     * @return string
     */
    public static function createAuthToken($info, RequestInterface $request)
    {
        return JWT::createToken($info, self::getJwtConfig($request));
    }
}