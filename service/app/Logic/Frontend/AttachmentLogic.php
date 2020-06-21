<?php
declare(strict_types=1);

namespace App\Logic\Frontend;

use App\Service\Common\AttachmentService;
use Hyperf\Di\Annotation\Inject;

class AttachmentLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var AttachmentService
     */
    public $service;
}