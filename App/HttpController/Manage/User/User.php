<?php
/**
 * 用户模块
 */

namespace App\HttpController\Manage\User;

use App\HttpController\Manage\Base;
use App\HttpController\Common\Common;
use App\HttpController\Common\ErrCode;

class User extends Base
{
    /**
     * 登陆
     * @return bool
     */
    public function login()
    {
        $raw_array = parent::getRawJson();
        $objResult = Common::createToken([]);
        if ($objResult->isSuccess()){
            return parent::writeJson(ErrCode::$CODE_SUCCESS, ['token' => $objResult->getData()], 'success');
        }
    }

    /**
     * 获取当前用户信息
     * @return bool
     */
    public function getInfo()
    {
        return parent::writeJson(ErrCode::$CODE_SUCCESS, ['name' => 'xiaoming', 'avatar' => ''], 'success');
    }

    /**
     * 退出登陆
     * @return bool
     */
    public function logout()
    {
        return parent::writeJson(ErrCode::$CODE_SUCCESS, [], 'success');
    }
}