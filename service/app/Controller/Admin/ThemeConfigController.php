<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\AuthMiddleware;
use App\Logic\Admin\ThemeConfigLogic;

/**
 * @AutoController()
 * @Middleware(AuthMiddleware::class)
 * Class ThemeConfigController
 * @package App\Controller\Admin
 */
class ThemeConfigController extends BaseController
{
    /**
     * @Inject()
     * @var ThemeConfigLogic
     */
    public $logic;
}
