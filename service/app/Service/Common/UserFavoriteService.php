<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Common\UserFavorite;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class UserFavoriteService extends BaseService
{
    /**
     * @Inject()
     * @var UserFavorite
     */
    public $model;
}