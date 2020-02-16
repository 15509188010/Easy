<?php
/**
 * 用户模块
 */

namespace App\HttpController\Manage\User;

use App\HttpController\Manage\Base;
use App\HttpController\Common\Common;
use App\HttpController\Common\ErrCode;
use App\Model\MAdmin;

use EasySwoole\Utility\Hash;

class User extends Base
{
    /**
     * 用户登陆
     * @return bool
     * @throws \EasySwoole\Mysqli\Exception\Exception
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
     */
    public function login()
    {
        $params = parent::getRawJson();
        $objMAdmin = new MAdmin();
        $dbResult = $objMAdmin->getAdminInfo(['number' => $params['username']]);//获取用户信息
        if (!$dbResult->isSuccess()) {
            return parent::writeJson($dbResult->getErrorCode(), [], $dbResult->getData());
        }
        $userInfo = $dbResult->getData();
        $bool = Hash::validatePasswordHash($params['password'], $userInfo['password']);
        if (!$bool) {
            return parent::writeJson(ErrCode::$accountfail, [], '用户名或密码错误');
        }
        $objResult = Common::createToken($userInfo);
        if ($objResult->isSuccess()) {
            return parent::writeJson(ErrCode::$CODE_SUCCESS, ['token' => $objResult->getData()], 'success');
        }
        return parent::writeJson(ErrCode::$paramError, [], '未知错误');
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
     * 获取用户列表
     * @return bool
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
     */
    public function getAll()
    {
        $params = parent::getRawJson();
        $objMAdmin = new MAdmin();
        $dbResult = $objMAdmin->getAll($params);
        if ($dbResult->isSuccess()) {
            $returnData = $dbResult->getData();
            $pageData = [
                'pageIndex' => $params['pageIndex'],
                'pageSize'  => $params['pageSize'],
                'pageTotal' => $returnData['total'],
            ];
            return parent::writeJson(ErrCode::$CODE_SUCCESS, array_merge($returnData, $pageData), 'success');
        }
        return parent::writeJson(ErrCode::$paramError, [], '未知错误');
    }
}