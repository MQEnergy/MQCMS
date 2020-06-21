<?php
declare(strict_types=1);

namespace App\Logic\Admin;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Service\Admin\CategoryService;
use Hyperf\Di\Annotation\Inject;

class CategoryLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var CategoryService
     */
    public $service;

    /**
     * @param \Hyperf\HttpServer\Contract\RequestInterface $data
     * @return int|void
     */
    public function store($data)
    {
        $data = [
            'cate_name' => $data['cate_name'],
            'alias_name' => $data['alias_name'],
            'cate_desc' => $data['cate_desc'],
            'parent_id' => $data['parent_id'],
            'seo_title' => $data['seo_title'],
            'seo_keyword' => $data['seo_keyword'],
            'seo_desc' => $data['seo_desc'],
            'list_template_id' => $data['list_template_id'],
            'detail_template_id' => $data['detail_template_id'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
        ];
        return $this->service->save($data);
    }

    /**
     * @param \Hyperf\HttpServer\Contract\RequestInterface $data
     * @return int|void
     */
    public function update($data)
    {
        $this->service->condition = ['id' => $data['id']];
        $this->service->data = [
            'cate_name' => $data['cate_name'],
            'alias_name' => $data['alias_name'],
            'cate_desc' => $data['cate_desc'],
            'parent_id' => $data['parent_id'],
            'seo_title' => $data['seo_title'],
            'seo_keyword' => $data['seo_keyword'],
            'seo_desc' => $data['seo_desc'],
            'list_template_id' => $data['list_template_id'],
            'detail_template_id' => $data['detail_template_id'],
            'status' => $data['status'],
        ];
        return $this->service->update();
    }

    /**
     * @param $id
     * @return bool|int
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->service->with = ['postList' => ['cate_id', 'post_title']];
        $this->service->condition = ['id' => $id];
        $cateInfo = $this->service->multiTableJoinQueryBuilder()->first();
        if (!$cateInfo) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '分类不存在');
        }
        $postList = $cateInfo->postList->toArray();
        if (!empty($postList)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '该分类下有文章，请删除文章');
        }
        if (!$cateInfo->delete()) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '删除失败');
        }
        return true;
    }
}