<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\UserAuth;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class UserAuthService extends BaseService
{
    /**
     * @Inject()
     * @var UserAuth
     */
    public $model;
}