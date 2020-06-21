<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\AdminRoleRelation;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class AdminRoleRelationService extends BaseService
{
    /**
     * @Inject()
     * @var AdminRoleRelation
     */
    public $model;
}
