<?php
/**
 * 用户模块
 */

namespace App\HttpController\User;

use App\HttpController\Base;

class User extends Base
{
    /**
     * 登陆
     * @return bool
     */
    public function login()
    {
        $raw_array = parent::getRawJson();
        return parent::writeJson(20000, ['token' => md5(123456)], 'success');
    }

    /**
     * 获取当前用户信息
     * @return bool
     */
    public function getInfo()
    {
        return parent::writeJson(20000, ['name' => 'xiaoming', 'avatar' => ''], 'success');
    }
}