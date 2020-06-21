<?php
declare(strict_types=1);

namespace App\Service\Admin;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Model\Common\Model;

class AdminService extends \App\Service\Common\AdminService
{
    /**
     * @param int $page
     * @param int $limit
     * @param array $search
     * @return \Hyperf\Contract\PaginatorInterface|mixed
     */
    public function index(int $page = 1, int $limit = 10, $search = [])
    {
        $data = parent::index($page, $limit, $search);

        foreach ($data['data'] as $key => &$value) {
            $value['avatar'] =  env('APP_UPLOAD_HOST_URL', '') . $value['avatar'];
            $value['register_time'] = $value['register_time'] ? date('Y-m-d H:i:s', (int)$value['register_time']) : '';
            $value['login_time'] = $value['login_time'] ? date('Y-m-d H:i:s', (int)$value['login_time']) : '';
        }
        return $data;
    }

    /**
     * 获取详情
     * @return \Hyperf\Database\Model\Model|\Hyperf\Database\Query\Builder|object|null
     */
    public function show()
    {
        $info = parent::show();
        $info['full_avatar'] =  env('APP_UPLOAD_HOST_URL', '') . $info['avatar'];
        return $info;
    }

    /**
     * @param $module
     * @return mixed
     */
    public function getModuleTbleList($module)
    {
        try {
            $moduleClass = 'App\\Model\\Common\\' . ucfirst($module);
            $reflectionClass = new \ReflectionClass($moduleClass);
            if (!$reflectionClass->isInstantiable()) {
                throw new BusinessException(ErrorCode::BAD_REQUEST, '当前类不可实例化');
            }
            $model = new $moduleClass();
            if (!($model instanceof Model)) {
                throw new BusinessException(ErrorCode::SERVER_ERROR);
            }
            return $model->getFillable();

        } catch (\Exception $e) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, $e->getMessage());
        }
    }

}