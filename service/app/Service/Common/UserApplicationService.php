<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\UserApplication;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class UserApplicationService extends BaseService
{
    /**
     * @Inject()
     * @var UserApplication
     */
    public $model;
}
