<?php
declare(strict_types=1);

namespace App\Logic\Frontend;

use App\Logic\AbstractLogic;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class BaseLogic extends AbstractLogic
{
    /**
     * @Inject()
     * @var BaseService
     */
    public $service;

    /**
     * @param int $page
     * @param int $limit
     * @param array $search
     * @return array
     */
    public function index($page=1, $limit=10, $search=[]): array
    {
        return $this->service->index($page, $limit, $search);
    }

    /**
     * @param RequestInterface $data
     * @return int|void
     */
    public function store($data)
    {
        $this->service->data = $data;
        return $this->service->store();
    }

    /**
     * @param RequestInterface $condition
     * @return array
     */
    public function show($id): array
    {
        $this->service->condition = ['id' => $id];
        return $this->service->show();
    }

    /**
     * @param RequestInterface $condition
     * @return int
     */
    public function delete($id)
    {
        $this->service->condition = ['id' => $id];
        return $this->service->delete();
    }

    /**
     * @param RequestInterface $request
     * @return int
     */
    public function update($data)
    {
        $this->service->condition = ['id' => $data['id']];
        unset($data['id']);
        $this->service->data = $data;
        return $this->service->update();
    }
}