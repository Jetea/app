<?php

namespace Ctx\Service\Ctx\Child;

use Ctx\Basic\Ctx;
use Ctx\Service\Ctx\Child\Queue\Job;
use Ctx\Service\Ctx\Child\Queue\Worker;
use Tree6bee\Queue\Drivers\Beanstalkd;
use Tree6bee\Queue\Queue as QueueService;

/**
 * 框架存储辅助类
 * @see example: https://github.com/Tree6bee/ctx_base/blob/master/tests/Service/Ctx/test_queue.php
 */
class Queue extends Ctx
{
    /**
     * 队列连接 实例，所有子类都会共享该属性
     */
    private static $connObj = array();

    /**
     * @param string $conn
     * @return QueueService
     */
    public function getQueue($conn = 'default')
    {
        if (! isset(self::$connObj[$conn])) {
            $config = $this->getItem($conn, null, 'queue');

            self::$connObj[$conn] = new QueueService(new Beanstalkd($config['host'], $config['port']));
        }

        return self::$connObj[$conn];
    }

    /**
     * @param Job $job
     * @return mixed
     */
    public function dispatch(Job $job)
    {
        return $this->getQueue($job->conn)->push($job);
    }

    /**
     * @param $delay
     * @param Job $job
     * @return mixed
     */
    public function laterDispatch($delay, Job $job)
    {
        return $this->getQueue($job->conn)->later($delay, $job);
    }

    /**
     *
     * Listen to the given queue in a loop.
     *
     * @param $conn
     * @param string $queueTube
     * @param int $sleep 没有新的有效任务产生时的休眠时间 (单位: 秒)
     * @param int $memoryLimit worker 内存限制 (单位: mb)
     */
    public function daemon($conn = 'default', $queueTube = '', $sleep = 60, $memoryLimit = 128)
    {
        $worker = new Worker($this->getQueue($conn), $queueTube);
        $worker->setCtx($this->ctx);
        $worker->daemon($sleep, $memoryLimit);
    }
}
