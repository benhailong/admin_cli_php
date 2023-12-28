<?php
namespace app\admin\service;

use app\admin\model\PortModel;
use think\facade\Db;

/**
 * 用户信息服务层
 */
class  VipTypeService {


    /**
     * 分页查询
     */
    public static function getListByPage($size, $page) {

        $array = Db::name('vip_type')
            ->alias('v')
            ->field('v.id, v.title, v.create_time, v.update_time')
            ->order(['v.id'=>'desc'])
            ->paginate([
                'list_rows' => $size,
                'page' => $page
            ]);

        // 获取图片列表
        $total = $array->total();
        $list = $array->items();

        return array('total' => $total, 'list' => $list);
    }



}
