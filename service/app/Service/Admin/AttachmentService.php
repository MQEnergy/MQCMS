<?php
declare(strict_types=1);

namespace App\Service\Admin;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;

class AttachmentService extends \App\Service\Common\AttachmentService
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
            $value['attach_full_url'] = env('APP_UPLOAD_HOST_URL', '') . $value['attach_url'];
        }
        return $data;
    }

    /**
     * @return array|int
     */
    public function store()
    {
        $data = $this->data;
        $res = parent::store();
        if (!$res) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '上传失败');
        }
        $data['attach_full_url'] = env('APP_UPLOAD_HOST_URL', '') . $data['attach_url'];
        return $data;
    }

    /**
     * @return int
     */
    public function delete()
    {
        // 删除资源
        $condition = $this->condition;
        $fileInfo = parent::show();
        if (empty($fileInfo)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '资源不存在');
        }
        $attachUrl = $fileInfo['attach_url'];
        $fullAttachUrl = BASE_PATH . DIRECTORY_SEPARATOR . $attachUrl;
        if (file_exists($fullAttachUrl)) {
            @unlink($fullAttachUrl);
        }
        $this->condition = $condition;
        return parent::delete();
    }
}