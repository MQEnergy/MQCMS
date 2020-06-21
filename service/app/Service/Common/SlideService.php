<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\Slide;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class SlideService extends BaseService
{
    /**
     * @Inject()
     * @var Slide
     */
    public $model;

}
