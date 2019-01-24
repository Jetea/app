<?php

namespace App\Commands;

use App\Application;

abstract class Command extends \Jetea\Framework\Routing\Controller
{
    /**
     * ctx 实例
     *
     * @var \Ctx\Ctx
     */
    protected $ctx;

    /**
     * Controller constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        // 引入 ctx
        $this->ctx = $app->getCtx();
    }
}
