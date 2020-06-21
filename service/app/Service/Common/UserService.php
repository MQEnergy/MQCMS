<?php
declare(strict_types = 1);

namespace App\Service\Common;

use App\Model\Entity\User;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class UserService extends BaseService
{
    /**
     * @Inject()
     * @var User
     */
    public $model;
}