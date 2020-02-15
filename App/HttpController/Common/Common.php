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
     * @return object
     */
    public static function createToken(array $data, string $alg = 'HMACSHA256')
    {
        $jwtObject = Jwt::getInstance()
            ->setSecretKey('easyswoole') // 秘钥
            ->publish();
        $jwtObject->setAlg($alg); // 加密方式
        $jwtObject->setAud('user'); // 用户
        $jwtObject->setExp(time() + 3600); // 过期时间
        $jwtObject->setIat(time()); // 发布时间
        $jwtObject->setIss('easyswoole'); // 发行人
        $jwtObject->setJti(md5(time())); // jwt id 用于标识该jwt
        $jwtObject->setNbf(time() + 60 * 5); // 在此之前不可用
        $jwtObject->setSub('主题'); // 主题
        // 自定义数据
        $jwtObject->setData([
            'other_info'
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
                    return ResultWrapper::fail('token无效', ErrCode::$paramError);
                    break;
                case  -2:
                    return ResultWrapper::fail('token过期', ErrCode::$paramError);
                    break;
            }
        } catch (\EasySwoole\Jwt\Exception $e) {
            return ResultWrapper::fail($e->getMessage(), ErrCode::$paramError);
        }
    }
}