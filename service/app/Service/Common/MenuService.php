<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\Menu;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class MenuService extends BaseService
{
    /**
     * @Inject()
     * @var Menu
     */
    public $model;

}
