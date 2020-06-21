<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\Navigation;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class NavigationService extends BaseService
{
    /**
     * @Inject()
     * @var Navigation
     */
    public $model;

}
