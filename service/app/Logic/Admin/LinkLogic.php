<?php
declare(strict_types=1);

namespace App\Logic\Admin;

use App\Service\Common\LinkService;
use Hyperf\Di\Annotation\Inject;

class LinkLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var LinkService
     */
    public $service;
}
