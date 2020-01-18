<?php

namespace App\HttpController;

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
        $this->response()->write(Render::getInstance()->render('index', ['time' => time()]));
    }
}