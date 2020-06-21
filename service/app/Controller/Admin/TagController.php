<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Logic\Admin\TagLogic;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use App\Middleware\AuthMiddleware;

/**
 * @Controller()
 * @Middleware(AuthMiddleware::class)
 * Class TagController
 * @package App\Controller\Admin
 */
class TagController extends BaseController
{
    /**
     *
     * @Inject()
     * @var TagLogic
     */
    public $logic;

    /**
     * @RequestMapping(path="store", methods="post")
     * @param RequestInterface $request
     * @return int
     */
    public function store(RequestInterface $request)
    {
        $post = $this->validateParam($request, [
            'tag_name' => 'required',
            'is_hot' => 'required|integer',
            'status' => 'required',
        ]);
        $post['uid'] = $request->getAttribute('uid');
        return $this->logic->store($post);
    }

    /**
     * @RequestMapping(path="update", methods="post")
     * @param RequestInterface $request
     * @return int
     */
    public function update(RequestInterface $request)
    {
        $post = $this->validateParam($request, [
            'id' => 'required',
            'tag_name' => 'required'
        ]);
        $post['tag_title'] = $request->input('tag_title', '');
        $post['tag_desc'] = $request->input('tag_desc', '');
        $post['tag_keyword'] = $request->input('tag_keyword', '');
        $post['is_hot'] = $request->input('is_hot', 0);
        $post['status'] = $request->input('status', 1);
        $post['tag_type'] = $request->input('tag_type', 1);
        return $this->logic->update($post);
    }

    /**
     * @GetMapping(path="show")
     * @param RequestInterface $request
     * @return array|\Hyperf\Database\Model\Model|\Hyperf\Database\Query\Builder|object|null
     */
    public function show(RequestInterface $request)
    {
        $params = $this->validateParam($request, [
            'id' => 'required'
        ]);
        $params['uid'] = $request->getAttribute('uid');
        return $this->logic->show($params);
    }
}