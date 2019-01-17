<?php

namespace App\Exceptions;

class Handler extends \Jetea\Exception\Handler
{
    private $debug;

    public function __construct($debug)
    {
        $this->debug = $debug;
    }

    /**
     * 错误日志记录
     */
    protected function report($e)
    {
        $log = $this->getLogOfException($e);
        //@todo 记录日志
    }

    /**
     * 渲染错误页面
     *
     * @param $e
     */
    protected function renderHttpException($e)
    {
        if ($this->debug) {
            parent::renderHttpException($e);
        } else {
            $this->renderErrorPage($e);
        }
    }

    /**
     * 渲染错误页面
     *
     * @param $e
     */
    protected function renderErrorPage($e)
    {
        if (! headers_sent()) {
            // header("HTTP/1.0 {$data['code']} " . get_class($exception));
            header("HTTP/1.0 500 " . 'Internal Server Error');
        }
        echo <<<EOF
<style type="text/css">
*{ padding: 0; margin: 0; }
body{padding: 24px 48px; background: #fff; font-family: "微软雅黑"; color: #333;}
h1{ font-size: 90px; font-weight: normal;}
p{ line-height: 1.8em; font-size: 24px }
</style>
<h1>:(</h1>
<p>哦豁，服务器异常.</p>
EOF;
    }
}
