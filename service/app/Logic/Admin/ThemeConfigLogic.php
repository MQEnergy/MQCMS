<?php
declare(strict_types=1);

namespace App\Logic\Admin;

use App\Service\Common\ThemeConfigService;
use Hyperf\Di\Annotation\Inject;

class ThemeConfigLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var ThemeConfigService
     */
    public $service;

    public function show($id): array
    {
        $info = parent::show($id);
        if (!empty($info)) {
            $info['full_thumb_url'] = env('APP_UPLOAD_HOST_URL', '') . $info['thumb_url'];
        }
        return $info;
    }
}
