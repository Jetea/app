<?php

namespace App;

use App\Exceptions\Handler;
use Jetea\Framework\Routing\Router;
use Jetea\Framework\Routing\Routes;
use Ctx\Ctx;

class Application extends \Jetea\Framework\Application
{
    /**
     * @var \Ctx\Ctx
     */
    private $ctx;

    protected function __construct()
    {
        parent::__construct();

        $this->ctx = Ctx::getInstance();

        $this->config = array_merge(
            $this->config,
            $this->ctx->Ctx->getConf('app')
        );
    }

    public function getCtx()
    {
        return $this->ctx;
    }

    protected $config = [
        'debug'         => false,
        'view'          => [
            'cache'     => __DIR__ . '/../storage/views',
        ],
    ];

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
        return new Handler($this->config('debug'));
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
