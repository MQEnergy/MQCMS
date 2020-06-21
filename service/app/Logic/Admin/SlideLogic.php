<?php
declare(strict_types=1);

namespace App\Logic\Admin;

use App\Service\Common\SlideService;
use Hyperf\Di\Annotation\Inject;

class SlideLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var SlideService
     */
    public $service;
}
