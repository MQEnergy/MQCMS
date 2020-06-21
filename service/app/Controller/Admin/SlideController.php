<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\AuthMiddleware;
use App\Logic\Admin\SlideLogic;

/**
 * @AutoController()
 * @Middleware(AuthMiddleware::class)
 * Class SlideController
 * @package App\Controller\Admin
 */
class SlideController extends BaseController
{
    /**
     * @Inject()
     * @var SlideLogic
     */
    public $logic;
}
