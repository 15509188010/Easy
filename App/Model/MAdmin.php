<?php
/**
 * Created by PhpStorm.
 * User: XiaoMing
 * Date: 2020/1/17
 * Time: 11:14
 */

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

class MAdmin extends AbstractModel
{
    protected $tableName = 'easy_admin';

    protected $primaryKey = 'id';


}