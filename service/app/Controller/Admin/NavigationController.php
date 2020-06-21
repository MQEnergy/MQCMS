<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\AuthMiddleware;
use App\Logic\Admin\NavigationLogic;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * @AutoController()
 * @Middleware(AuthMiddleware::class)
 * Class NavigationController
 * @package App\Controller\Admin
 */
class NavigationController extends BaseController
{
    /**
     * @Inject()
     * @var NavigationLogic
     */
    public $logic;

    public function store(RequestInterface $request)
    {
        $data = $this->validateParam($request, [
            'nav_name' => 'required',
        ]);
        $data['nav_desc'] = $request->input('nav_desc', '');
        $data['is_main'] = $request->input('is_main', 0);
        $data['status'] = $request->input('status', 1);
        return $this->logic->store($data);
    }

    public function update(RequestInterface $request)
    {
        $data = $this->validateParam($request, [
            'id' => 'required',
            'nav_name' => 'required',
        ]);
        $data['nav_desc'] = $request->input('nav_desc', '');
        $data['is_main'] = $request->input('is_main', 0);
        $data['status'] = $request->input('status', 1);
        return $this->logic->update($data);
    }
}
