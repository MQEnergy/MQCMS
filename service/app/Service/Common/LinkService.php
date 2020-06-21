<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\Link;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class LinkService extends BaseService
{
    /**
     * @Inject()
     * @var Link
     */
    public $model;

}
