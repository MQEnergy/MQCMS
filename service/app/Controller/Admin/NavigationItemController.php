<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\AuthMiddleware;
use App\Logic\Admin\NavigationItemLogic;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * @AutoController()
 * @Middleware(AuthMiddleware::class)
 * Class NavigationItemController
 * @package App\Controller\Admin
 */
class NavigationItemController extends BaseController
{
    /**
     * @Inject()
     * @var NavigationItemLogic
     */
    public $logic;

    public function index(RequestInterface $request)
    {
        $type = $request->input('type', 1);
        return $this->logic->getList($type);
    }

    public function list(RequestInterface $request)
    {
        return $this->logic->getCatePageList();
    }
}
