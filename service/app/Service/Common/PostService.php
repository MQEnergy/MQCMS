<?php
declare(strict_types = 1);

namespace App\Service\Common;

use App\Model\Entity\Post;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class PostService extends BaseService
{
    /**
     * @Inject()
     * @var Post
     */
    public $model;
}