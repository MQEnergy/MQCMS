<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\TagPostRelation;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class TagPostRelationService extends BaseService
{
    /**
     * @Inject()
     * @var TagPostRelation
     */
    public $model;
}