<?php
use Hyperf\HttpServer\Router\Router;
use App\Middleware\AuthMiddleware;

// Router::addGroup('news/', function () {
//     Router::get('index[/{cid:.+}]', 'App\Controller\Frontend\NewsController@index');
// });