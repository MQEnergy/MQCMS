<?php
declare(strict_types=1);

namespace App\Logic\Admin;

use App\Service\Common\NavigationService;
use Hyperf\Di\Annotation\Inject;

class NavigationLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var NavigationService
     */
    public $service;
}
