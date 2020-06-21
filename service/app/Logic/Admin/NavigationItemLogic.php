<?php
declare(strict_types=1);

namespace App\Logic\Admin;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Service\Admin\CategoryService;
use App\Service\Common\NavigationItemService;
use App\Utils\Common;
use Hyperf\Di\Annotation\Inject;

class NavigationItemLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var NavigationItemService
     */
    public $service;

    /**
     * @Inject()
     * @var CategoryService
     */
    public $categoryService;

    /**
     * @param int $type
     * @return array
     */
    public function getList(int $type=1)
    {
        $query = $this->service->multiTableJoinQueryBuilder();
        $list = $query->get()->toArray();
        foreach ($list as $key => &$value) {
            $value['created_at'] = date('Y-m-d H:i:s', (int) $value['created_at']);
            $value['updated_at'] = date('Y-m-d H:i:s', (int) $value['updated_at']);
        }
        switch ($type) {
            case 1:
                return Common::generateTree($list); // children 树状结果
                break;
            case 2:
                return $list;
                break;
            case 3:
                return Common::sonTree($list); // 字符串str_repeat
                break;
            default:
                throw new BusinessException(ErrorCode::BAD_REQUEST, '参数错误');
                break;
        }
    }

    /**
     * 获取所有分类和页面的列表
     * @return array
     */
    public function getCatePageList()
    {
        $cateList = $this->categoryService->multiTableJoinQueryBuilder()->get()->toArray();
        return compact('cateList');
    }
}
