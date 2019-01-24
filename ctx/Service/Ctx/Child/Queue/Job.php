<?php

namespace Ctx\Service\Ctx\Child\Queue;

use Ctx\Ctx;
use Tree6bee\Queue\Job as BasicJob;

abstract class Job extends BasicJob
{
    /**
     * @var string job 采用的连接
     */
    public $conn = 'default';

    /**
     * @var Ctx
     */
    public $ctx;
}
