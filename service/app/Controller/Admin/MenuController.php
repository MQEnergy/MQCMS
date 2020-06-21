<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Logic\Admin\MenuLogic;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use App\Middleware\AuthMiddleware;

/**
 * @Controller()
 * @Middleware(AuthMiddleware::class)
 * Class MenuController
 * @package App\Controller\Admin
 */
class MenuController extends BaseController
{
    /**
     * @Inject()
     * @var MenuLogic
     */
    public $logic;

    /**
     * @GetMapping(path="index")
     * @param RequestInterface $request
     * @return array|\Hyperf\Contract\PaginatorInterface
     */
    public function index(RequestInterface $request)
    {
        $type = $request->input('type', 1);
        $menuType = $request->input('menu_type', '');
        return $this->logic->getMenuList($type, $menuType);
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
            'title' => 'required',
            'alias_title' => 'required',
            'menu_type' => 'required',
            'status' => 'required',
            'sort_order' => 'required',
        ]);
        $post['desc'] = $request->input('desc', '');
        $post['frontend_url'] = $request->input('frontend_url', '');
        $post['backend_url'] = $request->input('backend_url', '');
        $post['custom'] = $request->input('custom', '');
        $post['parent_id'] = $request->input('parent_id', 0);
        $post['header'] = $request->input('header', '');
        return $this->logic->saveMenuInfo($post);
    }

    /**
     * @PostMapping(path="store")
     * @param RequestInterface $request
     * @return int
     */
    public function store(RequestInterface $request)
    {
        $post = $this->validateParam($request, [
            'title' => 'required',
            'alias_title' => 'required',
            'parent_id' => 'required',
            'menu_type' => 'required',
            'status' => 'required',
            'sort_order' => 'required',
        ]);
        $post['desc'] = $request->input('desc', '');
        $post['frontend_url'] = $request->input('frontend_url', '');
        $post['backend_url'] = $request->input('backend_url', '');
        $post['custom'] = $request->input('custom', '');
        $post['header'] = $request->input('header', '');
        return $this->logic->saveMenuInfo($post);
    }

    /**
     * @PostMapping(path="update-status")
     * @param RequestInterface $request
     * @return mixed
     */
    public function updateStatus(RequestInterface $request)
    {
        $post = $this->validateParam($request, [
            'id' => 'required',
            'status' => 'required',
        ]);
        return $this->logic->updateStatus($post['id'], $post['status']);
    }
}