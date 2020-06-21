<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\UploadSetting;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class UploadSettingService extends BaseService
{
    /**
     * @Inject()
     * @var UploadSetting
     */
    public $model;

}
