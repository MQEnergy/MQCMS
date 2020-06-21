<?php
declare(strict_types=1);

namespace App\Logic\Frontend;

use App\Service\Frontend\PostService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class NewsLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var PostService
     */
    public $service;

    public function index($page=1, $limit=10, $search=[]): array
    {
        return $this->service->getList($page, $limit, $search);
    }
}