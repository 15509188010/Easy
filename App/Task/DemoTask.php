<?php
/**
 * 异步任务模版demo
 * Created by PhpStorm.
 * User: XiaoMing
 * Date: 2020/1/17
 * Time: 14:25
 */

namespace App\Task;

use EasySwoole\Task\AbstractInterface\TaskInterface;

class DemoTask implements TaskInterface
{
    protected $data;
    //通过构造函数,传入数据,获取该次任务的数据
    public function __construct($data)
    {
        $this->data = $data;
    }

    function run(int $taskId, int $workerIndex)
    {
        var_dump("模板任务运行");
        var_dump($this->data);
        //只有同步调用才能返回数据
        return "返回值:".$this->data['name'];
        // TODO: Implement run() method.
    }

    function onException(\Throwable $throwable, int $taskId, int $workerIndex)
    {
        // TODO: Implement onException() method.
    }
}