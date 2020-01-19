<?php
/**
 * Created by PhpStorm.
 * User: XiaoMing
 * Date: 2020/1/19
 * Time: 16:21
 */

namespace App\Utility;

use EasySwoole\EasySwoole\Config;
use EasySwoole\Smtp\Mailer;
use EasySwoole\Smtp\MailerConfig;
use EasySwoole\Smtp\Message\Html;
use EasySwoole\Smtp\Message\Attach;

class Email
{
    /**
     * 邮箱信息
     * @param $email
     * @param $content
     * @param bool $extends
     */
    public static function send($email, $content, $extends = false)
    {
        $conf = Config::getInstance()->getConf('EMAIL');
        go(function () use ($email, $content, $extends, $conf) {
            $config = new MailerConfig();
            $config->setServer($conf['server']);
            $config->setSsl($conf['ssl']);
            $config->setUsername($conf['username']);
            $config->setPassword($conf['password']);
            $config->setMailFrom($conf['username']);
            $config->setTimeout($conf['timeout']);//设置客户端连接超时时间
            $config->setMaxPackage($conf['maxPackage']);//设置包发送的大小：5M

            $mimeBean = new Html();//设置文本或者html格式
            $mimeBean->setSubject('Email code!');
            $mimeBean->setBody('<h1>This is your verification code, valid for 5 minutes</h1><br>' . $content);
            //$mimeBean->addAttachment(Attach::create('./test.txt'));//添加附件
            $mailer = new Mailer($config);
            $mailer->sendTo($email, $mimeBean);
        });
    }
}