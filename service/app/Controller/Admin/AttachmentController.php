<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Logic\Admin\AttachmentLogic;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use App\Middleware\AuthMiddleware;

/**
 * @Controller()
 * @Middleware(AuthMiddleware::class)
 * Class AttachmentController
 * @package App\Controller\Admin
 */
class AttachmentController extends BaseController
{
    /**
     * @Inject()
     * @var AttachmentLogic
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
            'name' => 'required',
            'attach_url' => 'required',
            'status' => 'required',
        ]);
        return $this->logic->update($post);
    }

    /**
     * @RequestMapping(path="upload", methods="post")
     * @param RequestInterface $request
     * @return int
     */
    public function upload(RequestInterface $request)
    {
        return $this->logic->upload($request);
    }
}