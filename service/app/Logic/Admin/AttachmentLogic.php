<?php
declare(strict_types=1);

namespace App\Logic\Admin;

use App\Service\Admin\AttachmentService;
use App\Utils\Upload;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class AttachmentLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var AttachmentService
     */
    public $service;

    /**
     * 上传图片
     * @param RequestInterface $request
     * @return int
     */
    public function upload(RequestInterface $request)
    {
        $upload = new Upload();
        $pathInfo = $upload->uploadFile($request);

        if (in_array($upload->extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
            $attachType = 1;

        } else if (in_array($upload->extension, ['mp4', 'avi', 'rmvb'])) {
            $attachType = 2;

        } else {
            $attachType = 3;
        }
        $this->service->data = [
            'user_id'               => $request->getAttribute('uid'),
            'attach_origin_name'    => $upload->fileInfo['name'],
            'attach_name'           => $pathInfo['name'],
            'attach_url'            => $pathInfo['path'],
            'attach_type'           => $attachType,
            'attach_minetype'       => $upload->mineType,
            'attach_extension'      => $upload->extension,
            'attach_size'           => $upload->fileInfo['size'],
            'status'                => 1,
        ];
        return $this->service->store();
    }

    /**
     * @param $data
     * @return int
     */
    public function update($data): int
    {
        $this->service->condition = ['id' => $data['id']];
        $this->service->data = [
            'attach_name'   => trim($data['attach_name']),
            'attach_url'    => trim($data['attach_url']),
            'status'        => $data['status'],
        ];
        return $this->service->update();
    }

    /**
     * @param RequestInterface $request
     * @return int
     */
    public function delete($condition): int
    {
        $this->service->condition = $condition;
        return $this->service->delete();
    }
}