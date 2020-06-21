<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\UserInfo;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class UserInfoService extends BaseService
{
    /**
     * @Inject()
     * @var UserInfo
     */
    public $model;
}