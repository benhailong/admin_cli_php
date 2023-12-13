<?php
namespace app\admin\service;

use app\admin\model\PortModel;
use think\facade\Db;

/**
 * 角色 服务类
 */
class  RoleService {

    /**
     * 分页查询
     */
    public static function getListByPage($keywords,$size, $page) {

        $address = str_replace(' ','',$keywords);

        $array = Db::name('role')
            ->alias('r')
            ->field('r.id,r.name,r.label,r.introduce')
            ->where('r.name','like','%'.$keywords.'%')
            ->order(['r.id'=>'desc'])
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
