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
        $routeCollector->addRoute('POST', '/admin/user/login', '/Manage/User/User/login');//@后台登陆
        $routeCollector->addRoute('GET', '/admin/user/info', '/Manage/User/User/getInfo');//@获取当前用户信息
        $routeCollector->addRoute('POST', '/admin/user/logout', '/Manage/User/User/logout');//@退出登陆
        $this->setRouterNotFoundCallBack(function (Request $request, Response $response) {
            $response->write('not found router');
            return '';//重定向到index路由
        });
        $this->setMethodNotAllowCallBack(function (Request $request, Response $response) {
            $response->write('not found method');
            return false;//结束此次响应
        });
    }
}