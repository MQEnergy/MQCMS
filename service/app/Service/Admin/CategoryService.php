<?php
declare(strict_types=1);

namespace App\Service\Admin;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Model\Entity\Category;
use App\Utils\Common;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

class CategoryService extends \App\Service\Common\CategoryService
{
    /**
     * @Inject()
     * @var Category
     */
    public $model;

    /**
     * @param int $page
     * @param int $limit
     * @param array $search
     * @return \Hyperf\Contract\PaginatorInterface|mixed
     */
    public function index(int $page = 1, int $limit = 10, $search = [])
    {
        // 搜索
        if (!empty($search)) {
            $this->multiSingleTableSearchCondition($search);
        }
        $query = $this->multiTableJoinQueryBuilder();
        $total = $query->count();
        $list = $query->get()->toArray();
        foreach ($list as $key => &$value) {
            $value['created_at'] = date('Y-m-d H:i:s', (int)$value['created_at']);
            $value['updated_at'] = date('Y-m-d H:i:s', (int)$value['updated_at']);
        }
        $pagination['total'] = $total;
        $pagination['data'] = Common::sonTree($list, 'cate_name');
        return $pagination;
    }

    /**
     * 新增分类
     * @param $data
     * @return bool
     */
    public function save($data)
    {
        // 判断名称或者别名是否存在
        $this->condition = ['cate_name' => $data['cate_name']];
        $cateInfo = $this->multiTableJoinQueryBuilder()->orWhere(['alias_name' => $data['alias_name']])->first();
        if (!empty($cateInfo)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '名称或别名已经存在');
        }
        $menuInfo = new $this->model;
        $menuInfo->cate_name = $data['cate_name'];
        $menuInfo->alias_name = $data['alias_name'];
        $menuInfo->cate_desc = $data['cate_desc'];
        $menuInfo->parent_id = $data['parent_id'];
        $menuInfo->seo_title = $data['seo_title'];
        $menuInfo->seo_keyword = $data['seo_keyword'];
        $menuInfo->seo_desc = $data['seo_desc'];
        $menuInfo->list_template_id = $data['list_template_id'];
        $menuInfo->detail_template_id = $data['detail_template_id'];
        $menuInfo->status = $data['status'];
        $menuInfo->sort_order = $data['sort_order'];

        Db::beginTransaction();
        try {
            if (!$menuInfo->save()) {
                throw new BusinessException(ErrorCode::BAD_REQUEST, '保存失败：10000');
            }
            $id = $menuInfo->id;
            $this->condition = ['id' => $menuInfo->parent_id];
            $parentMenuInfo = $this->show();
            $path = $parentMenuInfo ? $parentMenuInfo['path'] . '-' : '';

            $menuInfo->path = $data['parent_id'] == 0 ? $id : $path . $id;

            if (!$menuInfo->save()) {
                throw new BusinessException(ErrorCode::BAD_REQUEST, '保存失败：10001');
            }
            Db::commit();
            return true;

        } catch (\Exception $e) {
            Db::rollBack();
            throw new BusinessException(ErrorCode::BAD_REQUEST, $e->getMessage());
        }
    }

}