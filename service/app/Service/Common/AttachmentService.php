<?php
declare(strict_types=1);

namespace App\Service\Common;

use App\Model\Entity\Attachment;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;

class AttachmentService extends BaseService
{
    /**
     * @Inject()
     * @var Attachment
     */
    public $model;
}