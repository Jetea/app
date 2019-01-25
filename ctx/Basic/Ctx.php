<?php

namespace Ctx\Basic;

use Jetea\Ctx\Basic\Ctx as BasicCtx;

/**
 * Ctx基类
 */
abstract class Ctx extends BasicCtx
{
    /**
     * @var \Ctx\Ctx $ctx
     */
    public $ctx;

    //todo
    protected function invokeRpc($method, $args)
    {
//        $rpc = new Client($this->rpc['host']);
//        return $rpc->exec($this->getModName(), $method, $args);
    }
}
