<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Logic\Admin\UserLogic;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use App\Middleware\AuthMiddleware;

/**
 * @Controller()
 * @Middleware(AuthMiddleware::class)
 * Class UserController
 * @package App\Controller\Admin
 */
class UserController extends BaseController
{
    /**
     * @Inject()
     * @var UserLogic
     */
    public $logic;

    /**
     * @PostMapping(path="store")
     * @param RequestInterface $request
     * @return int
     */
    public function store(RequestInterface $request)
    {
        $post = $this->validateParam($request, [
            'user_name' => 'required',
            'real_name' => 'required',
            'phone' => 'required',
        ]);
        $post['status'] = $request->input('status', 1);
        $post['ip'] = $request->getServerParams()['remote_addr'];

        return $this->logic->store($post);
    }

    /**
     * @PostMapping(path="update")
     * @param RequestInterface $request
     * @return int
     */
    public function update(RequestInterface $request)
    {
        $post = $this->validateParam($request, [
            'id' => 'required|integer',
            'user_name' => 'required',
            'real_name' => 'required',
            'phone' => 'required'
        ]);
        return $this->logic->update($post);
    }
}