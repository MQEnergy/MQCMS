<?php
declare(strict_types=1);

/**
 * auth控制器
 */
namespace App\Controller\Admin;

use App\Logic\Admin\AuthLogic;
use App\Utils\Redis;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use App\Middleware\AuthMiddleware;

/**
 * @Controller()
 * Class AuthController
 * @package App\Controller\Admin
 */
class AuthController extends BaseController
{
    /**
     * @Inject()
     * @var AuthLogic
     */
    public $logic;

    /**
     * @RequestMapping(path="register", methods="post")
     * @param RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function register(RequestInterface $request)
    {
        $post = $this->validateParam($request, [
            'account' => 'required',
            'phone' => 'required',
            'password' => 'required|max:100|min:6'
        ]);
        $post['ip'] = $request->getServerParams()['remote_addr'];
        return $this->logic->register($post, $request);
    }

    /**
     * @RequestMapping(path="login", methods="post")
     * @param RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login(RequestInterface $request)
    {
        $post = $this->validateParam($request, [
            'account' => 'required',
            'password' => 'required|max:100|min:6'
        ]);
        return $this->logic->login($post, $request);
    }

    /**
     * @RequestMapping(path="logout", methods="post")
     * @Middleware(AuthMiddleware::class)
     * @param RequestInterface $request
     * @return mixed
     */
    public function logout(RequestInterface $request)
    {
        return Redis::getContainer()->del('admin:token:' . $request->getAttribute('uuid'));
    }
}