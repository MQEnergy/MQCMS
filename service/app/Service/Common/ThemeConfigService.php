<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\ThemeConfig;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class ThemeConfigService extends BaseService
{
    /**
     * @Inject()
     * @var ThemeConfig
     */
    public $model;

}
