<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Entity\Tag;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class TagService extends BaseService
{
    /**
     * @Inject()
     * @var Tag
     */
    public $model;
}