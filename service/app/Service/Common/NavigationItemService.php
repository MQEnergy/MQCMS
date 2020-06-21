<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\NavigationItem;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class NavigationItemService extends BaseService
{
    /**
     * @Inject()
     * @var NavigationItem
     */
    public $model;

}
