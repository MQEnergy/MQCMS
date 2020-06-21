<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\AuthMiddleware;
use App\Logic\Admin\LinkLogic;

/**
 * @AutoController()
 * @Middleware(AuthMiddleware::class)
 * Class LinkController
 * @package App\Controller\Admin
 */
class LinkController extends BaseController
{
    /**
     * @Inject()
     * @var LinkLogic
     */
    public $logic;
}
