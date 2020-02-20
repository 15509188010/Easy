<?php

namespace App\Model;


use App\HttpController\Common\ErrCode;
use App\Utility\ResultWrapper;
use EasySwoole\ORM\AbstractModel;
use EasySwoole\Utility\Hash;
use EasySwoole\Utility\Random;

/**
 * 用户模型
 * Class MUser
 * @package App\Model
 */
class MUser extends AbstractModel
{
    protected $tableName = 'easy_user';
    protected $primaryKey = 'id';
    protected $autoTimeStamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    /**
     * @param $params
     * @return ResultWrapper
     * @throws \EasySwoole\Mysqli\Exception\Exception
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
     */
    public function getUserInfo(array $params)
    {
        $result = $this->get($params, true);
        if (empty($result)) {
            return ResultWrapper::fail('用户不存在', ErrCode::$userNotFount);
        }
        return ResultWrapper::success($result);
    }

    /**
     * @param array $params
     * @return ResultWrapper
     * @throws \Throwable
     */
    public function add(array $params)
    {
        try {
            $result = $this->data([
                'mobile'   => $params['mobile'],
                'password' => Hash::makePasswordHash($params['password']),
                'name'     => $params['mobile'],
                'reg_code' => Random::character(4) . '-' . Random::character(4),
            ], false)->save();
            if (empty($result)){
                return ResultWrapper::fail('未知错误', ErrCode::$dberror);
            }
            return ResultWrapper::success($result);
        }catch (\Exception $e){
            return ResultWrapper::fail($e->getMessage(), ErrCode::$dberror);
        }
    }
}