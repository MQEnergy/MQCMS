<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Logic\Admin\AdminLogic;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\AuthMiddleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * @Controller()
 * @Middleware(AuthMiddleware::class)
 * Class AdminController
 * @package App\Controller\Admin
 */
class AdminController extends BaseController
{
    /**
     * @Inject()
     * @var AdminLogic
     */
    public $logic;

    /**
     * @RequestMapping(path="update", methods="post")
     * @param RequestInterface $request
     * @return int
     */
    public function update(RequestInterface $request)
    {
        $post = $this->validateParam($request, [
            'id' => 'required',
            'account' => 'required',
            'real_name' => 'required',
            'phone' => 'required',
        ]);
        $post['ip'] = $request->getServerParams()['remote_addr'];
        $post['avatar'] = $request->input('avatar');
        $post['status'] = $request->input('status', 0);
        $post['password'] = $request->input('password');
        return $this->logic->update($post);
    }

    /**
     * @RequestMapping(path="store", methods="post")
     * @param RequestInterface $request
     * @return int
     */
    public function store(RequestInterface $request)
    {
        $post = $this->validateParam($request, [
            'account' => 'required',
            'real_name' => 'required',
            'phone' => 'required',
            'password' => 'required'
        ]);
        $post['ip'] = $request->getServerParams()['remote_addr'];
        $post['avatar'] = $request->input('avatar');
        $post['status'] = $request->input('status', 0);
        $post['password'] = $request->input('password');
        return $this->logic->store($post);
    }

    /**
     * @RequestMapping(path="module", methods="get")
     * @param RequestInterface $request
     * @return int
     */
    public function module(RequestInterface $request)
    {
        $params = $this->validateParam($request, [
           'module' => 'required'
        ]);
        return $this->logic->module($params);
    }

    /**
     * @PostMapping(path="clear-cache")
     * @param RequestInterface $request
     */
    public function clearCache(RequestInterface $request)
    {
        $post = $this->validateParam($request, [
           'type' => 'required'
        ]);
        return $this->logic->clearCache($post['type']);
    }

    /**
     * @GetMapping(path="role-list")
     * @param RequestInterface $request
     * @return array
     */
    public function roleList(RequestInterface $request)
    {
        $params = $this->validateParam($request, [
            'id' => 'required'
        ]);
        return $this->logic->getAdminRoleList($params['id']);
    }

    /**
     * @PostMapping(path="distribute-role")
     * @param RequestInterface $request
     * @return mixed
     */
    public function distributeRole(RequestInterface $request)
    {
        $post = $this->validateParam($request, [
            'uid' => 'required',
            'role_ids' => 'required',
        ]);
        return $this->logic->distributeAdminRole($post['uid'], $post['role_ids']);
    }

    /**
     * @GetMapping(path="permission")
     * @param RequestInterface $request
     * @return mixed
     */
    public function permission(RequestInterface $request)
    {
        $uid = $request->getAttribute('uid');
        return $this->logic->permission($uid);
    }

}