<?php

namespace App\HttpController;

use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\ORM\DbManager;


class Index extends Controller
{
    private $objMysqlPool;

    /**
     * Index constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->objMysqlPool = DbManager::getInstance();
    }


    /**
     *
     */
    public function index()
    {
        echo 123;
    }

    public function post()
    {
        echo 'post';
    }

    protected function actionNotFound(?string $action)
    {
        $this->response()->withStatus(404);
        $file = EASYSWOOLE_ROOT . '/vendor/easyswoole/easyswoole/src/Resource/Http/404.html';
        if (!is_file($file)) {
            $file = EASYSWOOLE_ROOT . '/src/Resource/Http/404.html';
        }
        $this->response()->write(file_get_contents($file));
    }
}