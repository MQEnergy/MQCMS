<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\Category;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class CategoryService extends BaseService
{
    /**
     * @Inject()
     * @var Category
     */
    public $model;
}