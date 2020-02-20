<?php
/**
 * 公共函数
 */

namespace App\HttpController\Common;

use EasySwoole\Jwt\Jwt;

use App\Utility\ResultWrapper;

class Common
{
    /**
     * 生成token
     * @param array $data
     * @param string $alg
     * @param string $action
     * @return ResultWrapper
     */
    public static function createToken(array $data, string $alg = 'HMACSHA256', string $action = '登陆')
    {
        $jwtObject = Jwt::getInstance()
            ->setSecretKey('easyswoole') // 秘钥
            ->publish();
        $jwtObject->setAlg($alg); // 加密方式
        $jwtObject->setAud($data['id']); // 用户
        $jwtObject->setExp(time() + 3600); // 过期时间
        $jwtObject->setIat(time()); // 发布时间
        $jwtObject->setIss('easyswoole'); // 发行人
        $jwtObject->setJti(md5(time())); // jwt id 用于标识该jwt
        $jwtObject->setNbf(time() + 60 * 5); // 在此之前不可用
        $jwtObject->setSub($action); // 主题
        // 自定义数据
        $jwtObject->setData([
            'number' => $data['number'],
            'name'   => $data['name']
        ]);
        // 最终生成的token
        $token = $jwtObject->__toString();
        return ResultWrapper::success($token);
    }

    /*
     * 解析token
     *
     * @param string $token
     * @return ResultWrapper
     */
    public static function decodeToken(string $token)
    {
        try {
            $jwtObject = Jwt::getInstance()->setSecretKey('easyswoole')->decode($token);
            $status = $jwtObject->getStatus();
            switch ($status) {
                case  1:
                    return ResultWrapper::success($jwtObject->toArray());
                    break;
                case  -1:
                    return ResultWrapper::fail('token无效', ErrCode::$notAllowToken);
                    break;
                case  -2:
                    return ResultWrapper::fail('token过期', ErrCode::$notAllowToken);
                    break;
            }
        } catch (\EasySwoole\Jwt\Exception $e) {
            return ResultWrapper::fail($e->getMessage(), ErrCode::$notAllowToken);
        }
    }

    /**
     * 验证手机号是否正确
     * @param $mobile
     * @return bool
     */
    public static function isMobile($mobile) {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^1[3,4,5,7,8,9]{1}[\d]{9}$#', $mobile) ? true : false;
    }


    /**
     * 正则表达式验证email格式
     *
     * @param string $str    所要验证的邮箱地址
     * @return boolean
     */
    public static function isEmail($str) {
        if (!$str) {
            return false;
        }
        return preg_match('#[a-z0-9&\-_.]+@[\w\-_]+([\w\-.]+)?\.[\w\-]+#is', $str) ? true : false;
    }

}