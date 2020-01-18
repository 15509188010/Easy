<?php
/**
 * 路由(此方法必须放在HttpController下否则不能被正常加载)
 * Created by PhpStorm.
 * User: XiaoMing
 * Date: 2020/1/17
 * Time: 11:25
 */

namespace App\HttpController;

use EasySwoole\Http\AbstractInterface\AbstractRouter;
use FastRoute\RouteCollector;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;

class Router extends AbstractRouter
{
    /**
     * @param RouteCollector $routeCollector
     */
    function initialize(RouteCollector $routeCollector)
    {
        $this->setGlobalMode(true);
        $routeCollector->addRoute(['POST', 'GET'], '/index', 'Index/index');
        $this->setRouterNotFoundCallBack(function (Request $request, Response $response) {
            $response->write('未找到路由匹配');
            return '/index';//重定向到index路由
        });
        $this->setMethodNotAllowCallBack(function (Request $request,Response $response){
            $response->write('未找到处理方法');
            return false;//结束此次响应
        });
    }
}