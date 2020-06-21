<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\UserLike;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class UserLikeService extends BaseService
{
    /**
     * @Inject()
     * @var UserLike
     */
    public $model;
}