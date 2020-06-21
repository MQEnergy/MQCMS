<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Logic\Admin\RoleLogic;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\AuthMiddleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * @Controller()
 * @Middleware(AuthMiddleware::class)
 * Class RoleController
 * @package App\Controller\Admin
 */
class RoleController extends BaseController
{
    /**
     * @Inject()
     * @var RoleLogic
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
            'name' => 'required',
            'status' => 'required'
        ]);
        $post['desc'] = $request->input('desc', '');
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
            'id' => 'required',
            'name' => 'required',
            'status' => 'required'
        ]);
        $post['desc'] = $request->input('desc', '');
        return $this->logic->update($post);
    }

    /**
     * @PostMapping(path="update-permission")
     * @param RequestInterface $request
     * @return int
     */
    public function updatePermission(RequestInterface $request)
    {
        $post = $this->validateParam($request, [
           'id' => 'required',
           'menu_ids' => 'required'
        ]);
        return $this->logic->updatePermission($post);
    }
}