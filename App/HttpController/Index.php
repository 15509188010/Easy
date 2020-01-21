<?php

namespace App\HttpController;

use EasySwoole\Template\Render;

class Index extends Base
{

    /**
     * Overrides
     * Index constructor.
     */
    public function __construct()
    {
        parent::__construct();
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
     * @throws \EasySwoole\ORM\Exception\Exception
     */
    public function index()
    {
    }

    public function login()
    {

    }
}