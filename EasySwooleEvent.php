<?php

namespace EasySwoole\EasySwoole;

use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\ORM\DbManager;
use EasySwoole\ORM\Db\Connection;
use EasySwoole\ORM\Db\Config;
use EasySwoole\Socket\Dispatcher;
use EasySwoole\Template\Render;


use App\WebSocket\WebSocketEvent;
use App\WebSocket\WebSocketParser;
use App\Utility\Template;
use App\Process\HotReload;

/**
 * Class EasySwooleEvent
 * @package EasySwoole\EasySwoole
 */
class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');
    }

    /**
     * @param EventRegister $register
     * @throws \EasySwoole\Pool\Exception\Exception
     * @throws \EasySwoole\Socket\Exception\Exception
     */
    public static function mainServerCreate(EventRegister $register)
    {
        // TODO: Implement mainServerCreate() method.
        /**************************************MYSQL连接池********************************************/
        $mysqlConf = \EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL');
        $config = new Config();
        $config->setDatabase($mysqlConf['database']);
        $config->setUser($mysqlConf['user']);
        $config->setPassword($mysqlConf['password']);
        $config->setHost($mysqlConf['host']);
        //连接池配置
        $config->setGetObjectTimeout(3.0); //设置获取连接池对象超时时间
        $config->setIntervalCheckTime(30 * 1000); //设置检测连接存活执行回收和创建的周期
        $config->setMaxIdleTime(15); //连接池对象最大闲置时间(秒)
        $config->setMaxObjectNum(20); //设置最大连接池存在连接对象数量
        $config->setMinObjectNum(5); //设置最小连接池存在连接对象数量
        DbManager::getInstance()->addConnection(new Connection($config));

        /***************************************注册热重启进程*****************************************/
        $swooleServer = ServerManager::getInstance()->getSwooleServer();
        $swooleServer->addProcess((new HotReload('HotReload', ['disableInotify' => true]))->getProcess());

        /***************************************注册模版*********************************************/
        Render::getInstance()->getConfig()->setRender(new Template());
        Render::getInstance()->attachServer(ServerManager::getInstance()->getSwooleServer());

        /***************************************注册WebSocket服务********************************************/
        $conf = new \EasySwoole\Socket\Config();// 创建一个 Dispatcher 配置
        $conf->setType(\EasySwoole\Socket\Config::WEB_SOCKET);// 设置 Dispatcher 为 WebSocket 模式
        $conf->setParser(new WebSocketParser());// 设置解析器对象
        $dispatch = new Dispatcher($conf);// 创建 Dispatcher 对象 并注入 config 对象
        // 给server 注册相关事件 在 WebSocket 模式下  on message 事件必须注册 并且交给 Dispatcher 对象处理
        $register->set(EventRegister::onMessage, function (\swoole_websocket_server $server, \swoole_websocket_frame $frame) use ($dispatch) {
            $dispatch->dispatch($server, $frame->data, $frame);
        });
        $websocketEvent = new WebSocketEvent();
        $register->set(EventRegister::onHandShake, function (\swoole_http_request $request, \swoole_http_response $response) use ($websocketEvent) {
            $websocketEvent->onHandShake($request, $response);//自定义握手事件
        });
        $register->set(EventRegister::onClose, function (\swoole_server $server, int $fd, int $reactorId) use ($websocketEvent) {
            $websocketEvent->onClose($server, $fd, $reactorId);//自定义关闭事件
        });

        /*******************************************注册REDIS连接池*****************************************/
        $config = new \EasySwoole\Pool\Config();
        $redisConfig = new \EasySwoole\Redis\Config\RedisConfig(\EasySwoole\EasySwoole\Config::getInstance()->getConf('REDIS'));
        \EasySwoole\Pool\Manager::getInstance()->register(new \App\Pool\RedisPool($config,$redisConfig),'redis');
    }

    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}