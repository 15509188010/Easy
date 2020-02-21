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
        /**
         * Manage路由
         */
        $routeCollector->addRoute('POST', '/admin/user/login', '/Manage/User/User/login');//@后台登陆
        $routeCollector->addRoute('GET', '/admin/user/info', '/Manage/User/User/getInfo');//@获取当前用户信息
        $routeCollector->addRoute('POST', '/admin/user/getAll', '/Manage/User/User/getAll');//@管理员列表

        /**
         * Api路由
         */
        $routeCollector->addRoute('POST', '/api/user/login', '/Api/User/User/login');//@前台登陆
        $routeCollector->addRoute('GET', '/api/user/getUser', '/Api/User/User/getUser');//@获取我的信息
        $routeCollector->addRoute('POST', '/api/user/register', '/Api/User/User/register');//@注册
        $routeCollector->addRoute('GET', '/api/index/banner', '/Api/Index/Index/banner');//@首页banner
        $routeCollector->addRoute('GET', '/api/index/secGoodsList', '/Api/Index/Index/secGoodsList');//@首页秒杀商品列表
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