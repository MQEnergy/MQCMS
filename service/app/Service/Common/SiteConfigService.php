<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\SiteConfig;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class SiteConfigService extends BaseService
{
    /**
     * @Inject()
     * @var SiteConfig
     */
    public $model;

}
