<?php
/**
 * Created by PhpStorm.
 * User: XiaoMing
 * Date: 2020/1/17
 * Time: 11:14
 */

namespace App\Model;

use App\HttpController\Common\ErrCode;
use App\HttpController\Common\StatusCode;
use App\Utility\ResultWrapper;
use EasySwoole\EasySwoole\Config;
use EasySwoole\ORM\AbstractModel;

class MAdmin extends AbstractModel
{
    protected $tableName = 'easy_admin';
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
    public function getAdminInfo(array $params)
    {
        $result = $this->get($params, true);
        if (empty($result)) {
            return ResultWrapper::fail('用户不存在', ErrCode::$userNotFount);
        }
        return ResultWrapper::success($result);
    }

    /**
     * 获取用户列表
     * @param array $params
     * @return ResultWrapper
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
     */
    public function getAll(array $params)
    {
        $pageIndex = $params['pageIndex'];
        $pageSize = $params['pageSize'];
        unset($params['pageSize']);
        unset($params['pageIndex']);
        $model = $this->limit($pageSize * ($pageIndex - 1), $pageSize)->withTotalCount();
        // 列表数据
        $list = $model->field('id,name,number,create_time,audit_status')->all([], true);
        // 总条数
        $total = $model->lastQueryResult()->getTotalCount();
        $return = [
            'data'  => self::format($list),
            'total' => $total,
        ];
        return ResultWrapper::success($return);
    }

    /**
     * 格式化数据
     * @param $data
     * @return mixed
     */
    public function format($data)
    {
        if (empty($data)) return $data;
        foreach ($data as &$val) {
            $val['create_time'] = date('Y-m-d H:i:s', $val['create_time']);
            $val['audit_mess'] = $val['audit_status'] == StatusCode::$auditStatus['pass'] ? '启用' : '禁用';
        }
        return $data;
    }
}