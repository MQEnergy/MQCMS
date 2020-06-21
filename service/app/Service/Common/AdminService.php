<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Entity\Admin;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class AdminService extends BaseService
{
    /**
     * @Inject()
     * @var Admin
     */
    public $model;
}