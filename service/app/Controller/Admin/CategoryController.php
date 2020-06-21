<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Logic\Admin\CategoryLogic;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\AuthMiddleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * @Controller()
 * @Middleware(AuthMiddleware::class)
 * Class PostController
 * @package App\Controller\Admin
 */
class CategoryController extends BaseController
{
    /**
     * @Inject()
     * @var CategoryLogic
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
            'cate_name' => 'required',
            'alias_name' => 'required',
            'status' => 'required'
        ]);
        $post['cate_desc'] = $request->input('cate_desc', '');
        $post['parent_id'] = $request->input('parent_id', 0);
        $post['seo_title'] = $request->input('seo_title', '');
        $post['seo_keyword'] = $request->input('seo_keyword', '');
        $post['seo_desc'] = $request->input('seo_desc', '');
        $post['list_template_id'] = $request->input('list_template_id', '');
        $post['detail_template_id'] = $request->input('detail_template_id', '');
        $post['sort_order'] = $request->input('sort_order', 50);
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
            'cate_name' => 'required',
            'alias_name' => 'required',
            'status' => 'required'
        ]);
        $post['cate_desc'] = $request->input('cate_desc', '');
        $post['parent_id'] = $request->input('parent_id', 0);
        $post['seo_title'] = $request->input('seo_title', '');
        $post['seo_keyword'] = $request->input('seo_keyword', '');
        $post['seo_desc'] = $request->input('seo_desc', '');
        $post['list_template_id'] = $request->input('list_template_id', '');
        $post['detail_template_id'] = $request->input('detail_template_id', '');
        return $this->logic->update($post);
    }

    /**
     * @PostMapping(path="delete")
     * @param RequestInterface $request
     * @return int
     */
    public function delete(RequestInterface $request)
    {
        $post = $this->validateParam($request, [
            'id' => 'required',
        ]);
        return $this->logic->delete($post['id']);
    }
}