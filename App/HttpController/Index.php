<?php

namespace App\HttpController;

use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\Component\Csp;
use EasySwoole\ORM\DbManager;

use App\Model\User;

class Index extends Controller
{
    private $objMysqlPool;
    private $objUser;

    /**
     * Index constructor.
     * @throws \EasySwoole\ORM\Exception\Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->objMysqlPool = DbManager::getInstance();
        $this->objUser = new User();
    }


    /**
     * @throws \EasySwoole\ORM\Exception\Exception
     */
    public function index()
    {
        var_dump($this->objUser->schemaInfo());

        $all = [
            [
                'id'        => 1,
                'payAmount' => 100,
            ],
            [
                'id'        => 2,
                'payAmount' => 200,
            ]
        ];
        go(function () use ($all) {
            $csp = new Csp();
            $csp->add('t1', function () use ($all) {
                \co::sleep(10);
                return false;
            });
            $csp->add('t2', function () use ($all) {
                \co::sleep(1);
                return true;
            });
            var_dump($csp->exec());
            var_dump($csp->successNum());
        });

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