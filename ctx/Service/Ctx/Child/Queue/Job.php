<?php

namespace Ctx\Service\Ctx\Child\Queue;

use Ctx\Ctx;
use Jetea\Queue\Job as BasicJob;

abstract class Job extends BasicJob
{
    /**
     * The name of the connection the job should be sent to.
     *
     * 在 ctx/Service/Ctx/Child/Queue.php getQueue 方法中被使用
     *
     * @var string|null
     */
    public $connection = 'default';

    /**
     * @var Ctx
     */
    public $ctx;
}
