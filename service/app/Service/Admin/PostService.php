<?php
declare(strict_types=1);

namespace App\Service\Admin;

class PostService extends \App\Service\Common\PostService
{
    /**
     * @param int $page
     * @param int $limit
     * @param array $search
     * @return \Hyperf\Contract\PaginatorInterface|mixed
     */
    public function index(int $page = 1, int $limit = 10, $search = [])
    {
        $this->with = [
            'adminInfo' => ['id', 'uuid', 'account'],
            'cateInfo' => ['id', 'cate_name']
        ];
        $this->condition = ['status' => 1];
        return parent::index($page, $limit, $search);
    }

    /**
     * @return \Hyperf\Database\Model\Model|\Hyperf\Database\Query\Builder|object|null
     */
    public function show()
    {
        $info = parent::show();
        if (!empty($info)) {
            $info['publish_time'] = date('Y-m-d H:i:s', $info['publish_time']);
            $info['full_thumb_url'] = $info['thumb_url'] ? env('APP_UPLOAD_HOST_URL', '') . $info['thumb_url'] : '';
        }
        return $info;
    }
}