<?php

namespace App\HttpController\Api\Index;

use App\HttpController\Api\Base;
use App\HttpController\Common\ErrCode;

/**
 * 首页控制器
 * Class Index
 * @package App\HttpController\Api\Index
 */
class Index extends Base
{
    /**
     * 获取banner
     * @return bool
     */
    public function banner()
    {
        $data = [
            [
                'src'        => '/static/temp/banner3.jpg',
                'background' => 'rgb(203, 87, 60)'
            ],
            [
                'src'        => '/static/temp/banner2.jpg',
                'background' => 'rgb(205, 215, 218)'
            ],
            [
                'src'        => '/static/temp/banner1.jpg',
                'background' => 'rgb(183, 73, 69)'
            ],
        ];

        return parent::writeJson(ErrCode::$CODE_SUCCESS, $data, 'success');
    }

    /**
     * 秒杀商铺列表
     * @return bool
     */
    public function secGoodsList()
    {
        $data = [
            [
                'id'       => 1,
                'image'    => 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1553005139&di=3368549edf9eee769a9bcb3fbbed2504&imgtype=jpg&er=1&src=http%3A%2F%2Fimg002.hc360.cn%2Fy3%2FM01%2F5F%2FDB%2FwKhQh1T7iceEGRdWAAAAADQvqk8733.jpg',
                'attr_val' => '春装款 L',
                'stock'    => 15,
                'title'    => 'OVBE 长袖风衣',
                'price'    => 278.00,
                'number'   => 1
            ],
            [
                'image'  => "https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=756705744,3505936868&fm=11&gp=0.jpg",
                'image2' => "http://images.jaadee.com/images/201702/goods_img/30150_d85aed83521.jpg",
                'image3' => "http://img13.360buyimg.com/popWaterMark/jfs/t865/120/206320620/138889/dcc94caa/550acedcN613e2a9d.jpg",
                'title'  => "私萱连衣裙",
                'price'  => 265,
                'sales'  => 88,
            ]
        ];

        return parent::writeJson(ErrCode::$CODE_SUCCESS, $data, 'success');
    }
}