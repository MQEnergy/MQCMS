<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\UserFollow;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class UserFollowService extends BaseService
{
    /**
     * @Inject()
     * @var UserFollow
     */
    public $model;
}