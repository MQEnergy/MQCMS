<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\UserTag;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class UserTagService extends BaseService
{
    /**
     * @Inject()
     * @var UserTag
     */
    public $model;
}