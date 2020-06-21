<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\AuthMiddleware;
use App\Logic\Admin\UploadSettingLogic;

/**
 * @AutoController()
 * @Middleware(AuthMiddleware::class)
 * Class UploadSettingController
 * @package App\Controller\Admin
 */
class UploadSettingController extends BaseController
{
    /**
     * @Inject()
     * @var UploadSettingLogic
     */
    public $logic;
}
