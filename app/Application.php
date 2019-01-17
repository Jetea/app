<?php

namespace App;

use App\Exceptions\Handler;
use Jetea\Framework\Routing\Router;
use Jetea\Framework\Routing\Routes;

class Application extends \Jetea\Framework\Application
{
    /**
     * web 全局中间件
     */
    protected $middleware = [
        // \Jetea\Framework\Foundation\Middleware\Xhprof::class,
    ];

    /**
     * @return Handler
     */
    protected function getExceptionsHandler()
    {
        return new Handler(true);
    }

    /**
     * 初始化路由
     *
     * @throws
     */
    protected function initRouter()
    {
        $this->router = new Router(function (Routes $routes) {
            if (PHP_SAPI != 'cli') { //只有非命令行模式下才采用
                require __DIR__ . '/routes/web.php';
            } else { //命令行模式下被当成了 get 请求
                $routes->get(Router::MAP_ROUTE, Router::MAP_ROUTE_HANDLER);
            }
        }, function ($handler, $var) {
            return Router::parseMapRouteInfo($handler, $var);
        });
    }
}
