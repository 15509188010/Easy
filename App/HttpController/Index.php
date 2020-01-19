<?php

namespace App\HttpController;

use App\Utility\Email;
use EasySwoole\ORM\DbManager;
use EasySwoole\Template\Render;

class Index extends Base
{
    private $objMysqlPool;

    /**
     * Overrides
     * Index constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->objMysqlPool = DbManager::getInstance();
    }

    /**
     * 重启子进程
     */
    public function reload()
    {
        Render::getInstance()->restartWorker();
        $this->response()->write(1);
    }

    /**
     *
     */
    public function index()
    {
        //Email::send('1023125136@qq.com','123456');测试发送邮件
        $this->response()->write(Render::getInstance()->render('index', ['time' => time()]));
    }
}