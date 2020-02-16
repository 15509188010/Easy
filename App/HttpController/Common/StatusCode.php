<?php

namespace App\HttpController\Common;


class StatusCode
{
    /**
     *
     * @var array
     */
    public static $auditStatus = [
        'waring' => 0,//禁用
        'pass'   => 1,//启用
    ];
}