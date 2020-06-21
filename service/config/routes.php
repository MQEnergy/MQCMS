<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\Frontend\HomeController@index');

/**
 * admin接口
 */
Router::addGroup('/admin/', function () {
    require_once dirname(__DIR__) . '/config/routes/admin.php';

    Router::addGroup('plugins/', function () {
        require_dir_script(dirname(__DIR__) . '/config/routes/plugins', 'admin');
    });
});

/**
 * frontend接口
 */
Router::addGroup('/frontend/', function () {
    require_once dirname(__DIR__) . '/config/routes/frontend.php';
});