<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\AuthMiddleware;
use App\Logic\Admin\SiteConfigLogic;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * @AutoController()
 * @Middleware(AuthMiddleware::class)
 * Class SiteConfigController
 * @package App\Controller\Admin
 */
class SiteConfigController extends BaseController
{
    /**
     * @Inject()
     * @var SiteConfigLogic
     */
    public $logic;

    /**
     * @param RequestInterface $request
     * @return int|void
     */
    public function store(RequestInterface $request)
    {
        $data = $this->validateParam($request, [
            'site_name' => 'required',
            'theme_id' => 'required',
        ]);
        $data['icp_no'] = $request->input('icp_no', '');
        $data['safe_record'] = $request->input('safe_record', '');
        $data['site_email'] = $request->input('site_email', '');
        $data['site_analytics'] = $request->input('site_analytics', '');
        $data['seo_title'] = $request->input('seo_title', '');
        $data['seo_keyword'] = $request->input('seo_keyword', '');
        $data['seo_description'] = $request->input('seo_description', '');
        $data['cdn_url'] = $request->input('cdn_url', '');
        return $this->logic->store($data);
    }

    public function show(RequestInterface $request)
    {
        return $this->logic->show($request->input('id'));
    }

    public function update(RequestInterface $request)
    {
        $data = $this->validateParam($request, [
            'id' => 'required',
            'site_name' => 'required',
            'theme_id' => 'required',
        ]);
        $data['icp_no'] = $request->input('icp_no', '');
        $data['safe_record'] = $request->input('safe_record', '');
        $data['site_email'] = $request->input('site_email', '');
        $data['site_analytics'] = $request->input('site_analytics', '');
        $data['seo_title'] = $request->input('seo_title', '');
        $data['seo_keyword'] = $request->input('seo_keyword', '');
        $data['seo_description'] = $request->input('seo_description', '');
        $data['cdn_url'] = $request->input('cdn_url', '');
        return $this->logic->update($data);
    }
}
