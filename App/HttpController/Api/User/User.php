<?php

namespace App\HttpController\Api\User;

use App\HttpController\Api\Base;
use App\HttpController\Common\Common;
use App\HttpController\Common\ErrCode;
use App\Model\MUser;
use EasySwoole\Utility\Hash;

/**
 * App 用户控制器
 * Class User
 * @package App\HttpController\Api\User
 */
class User extends Base
{
    /**
     * @return bool
     * @throws \EasySwoole\Mysqli\Exception\Exception
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
     */
    public function login()
    {
        $params = parent::getRawJson();
        $objMUser = new MUser();
        $dbResult = $objMUser->getUserInfo(['mobile' => $params['mobile']]);
        if (!$dbResult->isSuccess()) {
            return parent::writeJson($dbResult->getErrorCode(), [], $dbResult->getData());
        }
        $userInfo = $dbResult->getData();
        $bool = Hash::validatePasswordHash($params['password'], $userInfo['password']);
        if (!$bool) {
            return parent::writeJson(ErrCode::$accountfail, [], '用户名或密码错误');
        }
        $objResult = Common::createToken([
            'id'     => $userInfo['id'],
            'number' => $userInfo['mobile'],
            'name'   => $userInfo['name']
        ]);
        if ($objResult->isSuccess()) {
            $return = [
                'id'       => $userInfo['id'],
                'mobile'   => $userInfo['mobile'],
                'nickname' => $userInfo['name'],
                'token'    => $objResult->getData()
            ];
            return parent::writeJson(ErrCode::$CODE_SUCCESS, $return, 'success');
        }
        return parent::writeJson(ErrCode::$paramError, [], '未知错误');
    }

    /**
     * @return bool
     * @throws \EasySwoole\Mysqli\Exception\Exception
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
     */
    public function register()
    {
        $params = parent::getRawJson();
        if (!Common::isMobile($params['mobile'])){
            return parent::writeJson(ErrCode::$paramError,[],'不是有效的手机号');
        }
        if (empty($params['password']) || strlen($params['password']) < 8){
            return parent::writeJson(ErrCode::$paramError,[],'密码不符合规则');
        }
        $objMUser = new MUser();
        $dbResult = $objMUser->getUserInfo(['mobile' => $params['mobile']]);
        if ($dbResult->isSuccess()){
            return parent::writeJson(ErrCode::$paramError,[],'手机号码已被占用');
        }
        unset($dbResult);
        $dbResult = $objMUser->add($params);
        if (!$dbResult->isSuccess()){
            return parent::writeJson($dbResult->getErrorCode(),[],$dbResult->getData());
        }
        return parent::writeJson(ErrCode::$CODE_SUCCESS, [], '注册成功');
    }

    public function getUser()
    {
        $return = [
            'money' => '1999.00',
        ];
        return parent::writeJson(ErrCode::$CODE_SUCCESS, $return, 'success');
    }
}