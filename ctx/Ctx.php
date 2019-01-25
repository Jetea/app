<?php

namespace Ctx;

use Jetea\Ctx\Ctx as BasicCtx;

/**
 * Context 上下文
 *
 * @property \Ctx\Service\Ctx\Ctx $Ctx
 */
class Ctx extends BasicCtx
{
    protected static $ctxInstance;

    /**
     * ctx命名空间
     */
    protected $ctxNamespace = 'Ctx';
}
