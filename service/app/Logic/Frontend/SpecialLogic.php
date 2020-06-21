<?php
declare(strict_types=1);

namespace App\Logic\Frontend;

use App\Service\Frontend\PostService;
use Hyperf\Di\Annotation\Inject;

class SpecialLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var PostService
     */
    public $service;
}