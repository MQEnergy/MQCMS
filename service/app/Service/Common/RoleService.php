<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\Role;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class RoleService extends BaseService
{
    /**
     * @Inject()
     * @var Role
     */
    public $model;
}
