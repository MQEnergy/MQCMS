<?php
declare(strict_types=1);

namespace App\Logic\Admin;

use App\Service\Admin\PostService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class PostLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var PostService
     */
    public $service;

    /**
     * @param RequestInterface $request
     * @return int
     * @throws \Exception
     */
    public function update($data)
    {
        $this->service->condition = ['id' => $data['id']];
        unset($data['id']);
        $this->service->data = $data;
        return $this->service->update();
    }

    /**
     * @param RequestInterface $request
     * @return int
     */
    public function store($data)
    {
        $this->service->data = $data;
        return $this->service->store();
    }
}