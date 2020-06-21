<?php
declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Logic\Frontend\HomeLogic;
use App\Utils\Common;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\View\RenderInterface;

/**
 * @Controller()
 * Class HomeController
 * @package App\Controller\Frontend
 */
class HomeController extends BaseController
{
    /**
     * @Inject()
     * @var HomeLogic
     */
    public $logic;

    /**
     * @GetMapping(path="index.html[/[{option:.+}]]")
     * @param RenderInterface $render
     * @param RequestInterface $request
     * @return array
     */
    public function index(RenderInterface $render, RequestInterface $request)
    {
        $router = $request->getRequestUri();
        $data = [];
        return $render->render(Common::getTemplatePath($this, __FUNCTION__), compact('data', 'router'));
    }
}