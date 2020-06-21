<?php
declare(strict_types=1);

namespace App\Logic\Frontend;

use App\Service\Frontend\UserService;
use Hyperf\Di\Annotation\Inject;

class UcenterLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var UserService
     */
    public $service;
}