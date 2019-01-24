<?php

namespace Ctx\Service\Ctx\Child\Queue;

use Ctx\Ctx;
use Tree6bee\Queue\Worker as BasicWorker;
use Tree6bee\Queue\Job;

class Worker extends BasicWorker
{
    /**
     * @var Ctx
     */
    private $ctx;

    public function setCtx(Ctx $ctx)
    {
        $this->ctx = $ctx;
    }

    /**
     * 记录 job 执行失败的日志
     * !!! 此处根据具体的框架应用进行重载来记录符合业务的日志格式
     * !!! you can override this method to log the job processing error, etc...
     * @param \Exception $e
     *
     * @return void
     */
    protected function logProcessError(\Exception $e)
    {
        parent::logProcessError($e);
    }

    /**
     * !!! 此处根据具体的框架应用进行重载，方便注入框架的服务对象等
     * !!! you can override this method, so that the application job can init with more obj, etc...
     *
     * @param Job $obj job 中反序列化后具体的实例对象 应用开发者定义的 application job
     */
    protected function handleWithObj(Job $obj)
    {
        /** @var \Ctx\Service\Ctx\Child\Queue\Job $obj */
        $obj->ctx = $this->ctx;

        parent::handleWithObj($obj);
    }

    /**
     * !!! override 采用cache存储 重启命令执行时间 和 worker $startTime 比较
     * @param $startTime
     * @return bool
     */
    protected function queueShouldRestart($startTime)
    {
        return false;
    }
}
