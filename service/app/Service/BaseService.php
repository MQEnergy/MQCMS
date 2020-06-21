<?php
declare(strict_types=1);

namespace App\Service;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Model\Common\Model;
use App\Utils\Common;
use Carbon\Carbon;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Paginator\Paginator;

class BaseService
{
    /**
     * @var string
     */
    public $model = '';

    /**
     * join表查询参数
     * @var array
     * 用法：
     * [
     *    join表名 => [主表.字段, '=', join表名.字段],
     *    join表名 => [主表.字段, '=', join表名.字段],
     *    join表名 => [主表.字段, '=', join表名.字段],
     * ]
     */
    public $joinTables = [];

    /**
     * 查询条件
     * @var array
     * 用法：
     * [
     *    [表名.字段, '=', 值],
     *    [表名.字段, '=', 值],
     * ]
     *
     * [字段 => 值, 字段 => 值 ...]
     */
    public $condition = [];

    /**
     * 查询数据
     * @var array
     * 用法：
     * 单表（如果连表查单表数据）：
     * ['*']
     * ['字段', ...]
     *
     * 多变join方式：
     * [
     *    表名 => ['字段', ....],
     * ]
     * 多表：
     * [
     *    主表 => ['字段', ....],
     *    其他表 => ['字段', ....]
     * ]
     */
    public $select = ['*'];

    /**
     * 排序
     * @var string|array
     * 用法：
     * 1、单表排序的格式是字符串 "字段 DESC/ASC"
     * 2、多表排序的格式是数据
     * [
     *    表名 => [字段 => 'DESC/ASC'],
     *    表名 => [字段 => 'DESC/ASC'],
     * ]
     */
    public $orderBy = 'id desc';

    /**
     * 分组
     * @var array
     * 用法：
     * [字段，字段...]
     */
    public $groupBy = [];

    /**
     * 存储数组
     * @var array
     */
    public $data = [];

    /**
     * Relations
     * @var array
     * 用法1：
     * [relationsName1，relationsName2...]
     * 用法2：（查询个别字段）
     * [
     *    关联模型名称1 => ['字段', ....],
     *    关联模型名称2 => ['字段', ....],
     * ]
     */
    public $with = [];

    /**
     * BaseService constructor.
     */
    public function __construct()
    {
        $this->resetAttributes();
    }

    /**
     * 重置属性值
     */
    public function resetAttributes()
    {
        $this->joinTables = [];
        $this->condition = [];
        $this->select = ['*'];
        $this->orderBy = 'id desc';
        $this->groupBy = [];
        $this->data = [];
        $this->with = [];
    }

    /**
     * 获取分页列表
     * @param RequestInterface $request
     * @return \Hyperf\Contract\PaginatorInterface|mixed
     */
    public function index(int $page = 1, int $limit = 10, $search=[])
    {
        try {
            // 搜索
            if (!empty($search)) {
                $this->multiSingleTableSearchCondition($search);
            }
            $pagination = $this->getListByPage($page, $limit);

            foreach ($pagination['data'] as $key => &$value) {
                isset($value['created_at']) && $value['created_at'] = date('Y-m-d H:i:s', (int) $value['created_at']);
                isset($value['updated_at']) && $value['updated_at'] = date('Y-m-d H:i:s', (int) $value['updated_at']);
            }
            return $pagination;

        } catch (\Exception $e) {
            throw new BusinessException((int)$e->getCode(), $e->getMessage());
        }
    }

    /**
     * 展示详情
     * @param RequestInterface $request
     * @return \Hyperf\Database\Model\Model|\Hyperf\Database\Query\Builder|object|null
     */
    public function show()
    {
        try {
            $info = $this->multiTableJoinQueryBuilder()->first();
            if (!$info) {
                return [];
            }
            $data = $info->toArray();
            isset($info->created_at) && $data['created_at'] = $info->created_at instanceof Carbon ? $info->created_at->toDateTimeString() : date('Y-m-d H:i:s', $info->created_at);
            isset($info->updated_at) && $data['updated_at'] = $info->updated_at instanceof Carbon ? $info->updated_at->toDateTimeString() : date('Y-m-d H:i:s', $info->updated_at);
            return $data;

        } catch (\Exception $e) {
            throw new BusinessException((int)$e->getCode(), $e->getMessage());
        }
    }

    /**
     * 从缓存中获取详情
     * @param $id
     * @return array
     */
    public function showFromCache($id)
    {
        try {
            if (!$this->model || !($this->model instanceof Model)) {
                throw new BusinessException(ErrorCode::SERVER_ERROR);
            }
            $info = $this->model::findFromCache($id);
            if (!$info) {
                return [];
            }
            $data = $info->toArray();
            isset($info->created_at) && $data['created_at'] = $info->created_at instanceof Carbon ? $info->created_at->toDateTimeString() : date('Y-m-d H:i:s', $info->created_at);
            isset($info->updated_at) && $data['updated_at'] = $info->updated_at instanceof Carbon ? $info->updated_at->toDateTimeString() : date('Y-m-d H:i:s', $info->updated_at);
            return $data;

        } catch (\Exception $e) {
            throw new BusinessException((int)$e->getCode(), $e->getMessage());
        }
    }

    /**
     * 删除
     * @param RequestInterface $request
     * @return int
     */
    public function delete()
    {
        try {
            return $this->multiTableJoinQueryBuilder()->delete();

        } catch (\Exception $e) {
            throw new BusinessException((int)$e->getCode(), $e->getMessage());
        }
    }

    /**
     * 更新
     * @param RequestInterface $request
     * @param $data
     * @return int
     */
    public function update()
    {
        try {
            $data = $this->data;
            return $this->multiTableJoinQueryBuilder()->update($data);

        } catch (\Exception $e) {
            throw new BusinessException((int)$e->getCode(), $e->getMessage());
        }
    }

    /**
     * 存储或更新
     * @param RequestInterface $request
     * @return int
     */
    public function store()
    {
        try {
            $data = $this->data;
            if (!empty($this->condition)) {
                $model = $this->multiTableJoinQueryBuilder()->first();
                if (!$model) {
                    $model = new $this->model;
                }
            } else {
                $model = new $this->model;
            }
            $tableAttributes = $this->model->getFillable();
            $searchKeys = array_intersect(array_keys($data), $tableAttributes);

            foreach ($searchKeys as $key => $value) {
                $model->$value = $data[$value];
            }
            return $model->save();

        } catch (\Exception $e) {
            throw new BusinessException((int)$e->getCode(), $e->getMessage());
        }
    }

    /**
     * 存储获取最新ID
     * @param RequestInterface $request
     * @return bool
     */
    public function insert()
    {
        try {
            $data = $this->data;
            return $this->multiTableJoinQueryBuilder()->insertGetId($data);

        } catch (\Exception $e) {
            throw new BusinessException((int)$e->getCode(), $e->getMessage());
        }
    }

    /**
     * 根据查询结果获取分页列表
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function getListByPage(int $page, int $limit)
    {
        $select = $this->select;
        $query = $this->multiTableJoinQueryBuilder();
        $count = $query->count();
        $pagination = $query->paginate($limit, array_values($select), 'page', $page)->toArray();
        $pagination['total'] = $count;
        return $pagination;
    }

    /**
     * 根据结果数组分页
     * @param $data
     * @param $per_page
     * @param $current_page
     * @return Paginator
     */
    public static function lists($data, $per_page, $current_page)
    {
        return new Paginator($data, $per_page, $current_page);
    }

    /**
     * 单多表关联查询构造器
     * 注意：此方法因为在构造完成会重置参数(resetAttributes)，如再次使用condition, select, orderBy等参数，请在构造之前用变量存储
     * @return \Hyperf\Database\Query\Builder
     */
    public function multiTableJoinQueryBuilder()
    {
        if (!$this->model || !($this->model instanceof Model)) {
            throw new BusinessException(ErrorCode::SERVER_ERROR);
        }
        $query = $this->model::query();

        if (!empty($this->with)) {
            $arrCount = Common::getArrCountRecursive($this->with);
            array_walk($this->with, function (&$item, $key) use (&$query, $arrCount) {
                if ($arrCount === 1) {
                    $query = $query->with($item);

                } else if ($arrCount === 2 && !is_numeric($key)) {
                    $query = $query->with([$key => function ($query) use ($item) {
                        return $query->select($item);
                    }]);
                }
            });
        } else {
            if (is_array($this->joinTables) && !empty($this->joinTables)) {
                array_walk($this->joinTables, function (&$item, $key) use (&$query) {
                    if (count($item) === 3) {
                        $query = $query->leftJoin($key, $item[0], $item[1], $item[2]);
                    }
                });

                if (is_array($this->select) && !empty($this->select)) {
                    $arrCount = Common::getArrCountRecursive($this->select);
                    $select = [];
                    if ($arrCount === 1) {
                        array_walk($this->select, function ($item) use (&$select) {
                            $select[] = $this->model->getTable() . '.' . $item;
                        });
                    } else {
                        foreach ($this->select as $key => $value) {
                            if (is_array($value)) {
                                array_walk($value, function ($item) use ($key, &$select) {
                                    $select[] = $key . '.' . $item;
                                });
                            } else {
                                $select[] = $key . '.' . $value;
                            }
                        }
                        $select = !empty($select) ? $select : $this->select;
                    }
                    $query = $query->select($select);
                }
            } else {
                $query = $query->select($this->select);
            }
        }

            if (!empty($this->condition)) {
            $query = $query->where($this->condition);
        }

        if (is_array($this->orderBy) && !empty($this->orderBy)) {
            $orderBy = [];
            foreach ($this->orderBy as $key => $value) {
                if (is_array($value)) {
                    $orderKey = array_keys($value);
                    foreach ($orderKey as $k => $v) {
                        $orderBy[] = env('DB_PREFIX', 'mq_') . "{$key}.{$v} {$value[$v]}";
                    }
                }
            }
            $orderBy = !empty($orderBy) ? implode(',', $orderBy) : $this->orderBy;
            $query = $query->orderByRaw($orderBy);
        } else {
            $query = $query->orderByRaw($this->orderBy);
        }

        if (!empty($this->groupBy)) {
            $query = $query->groupBy(implode(',', $this->groupBy));
        }
        $this->resetAttributes();
        return $query;
    }

    /**
     * 构建单表多条件查询
     * @param $searchForm
     * @return array
     */
    public function multiSingleTableSearchCondition($searchForm)
    {
        if (!$this->model || !($this->model instanceof Model)) {
            throw new BusinessException(ErrorCode::SERVER_ERROR);
        }
        $searchForm = is_array($searchForm) ? $searchForm : json_decode($searchForm, true);
        $type = isset($searchForm['_type']) ? $searchForm['_type'] : '';
        $keyword = isset($searchForm['_keyword']) ? trim($searchForm['_keyword']) : '';
        $timeForm = isset($searchForm['_time']) ? $searchForm['_time'] : [];
        $condition = $this->condition;
        $tableAttributes = $this->model->getFillable();

        if ($keyword && in_array($type, $tableAttributes)) {
            $condition[] = [$this->model->getTable() . '.' . $type, 'like', "%{$keyword}%"];
        }
        $searchKeys = array_intersect(array_keys($searchForm), $tableAttributes);
        if (!empty($searchKeys)) {
            array_walk($searchKeys, function ($item) use (&$condition, $searchForm) {
                if (isset($searchForm[$item]) && $searchForm[$item] !== '') {
                    array_push($condition, [$this->model->getTable() . '.' . $item, '=', $searchForm[$item]]);
                }
            });
        }
        $searchKeys = array_intersect(array_keys($timeForm), $tableAttributes);
        if (!empty($searchKeys)) {
            array_walk($searchKeys, function ($item) use (&$condition, $timeForm) {
                if (isset($timeForm[$item]) && ($timeForm[$item] || !empty($timeForm[$item]))) {
                    if (is_array($timeForm[$item]) && count($timeForm[$item]) === 2) {
                        if ($timeForm[$item][0] !== '' && $timeForm[$item][1] !== '') {
                            array_push($condition, [$this->model->getTable() . '.' . $item, '>=', strtotime($timeForm[$item][0])]);
                            array_push($condition, [$this->model->getTable() . '.' . $item, '<=', strtotime($timeForm[$item][1])]);
                        }
                    } else {
                        array_push($condition, [$this->model->getTable() . '.' . $item, '>=', strtotime($timeForm[$item])]);
                    }
                }
            });
        }
        if (!empty($condition)) {
            $this->condition = $condition;
        }
        return $condition;
    }
}