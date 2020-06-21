<?php
declare(strict_types=1);

namespace App\Logic\Admin;

use App\Service\Common\UploadSettingService;
use Hyperf\Di\Annotation\Inject;

class UploadSettingLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var UploadSettingService
     */
    public $service;
}
