<?php
declare(strict_types=1);

namespace App\Logic\Admin;

use App\Service\Common\SiteConfigService;
use Hyperf\Di\Annotation\Inject;

class SiteConfigLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var SiteConfigService
     */
    public $service;

    public function show($id): array
    {
        if (!$id) {
            $info = $this->service->multiTableJoinQueryBuilder()->get()->toArray();
            return $info ? $info[0] : [];
        }
        return parent::show($id);
    }
}
