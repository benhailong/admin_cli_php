<?php
namespace app\admin\service;

use app\admin\model\PortModel;
use app\admin\model\VipModel;
use app\admin\model\VipTypeModel;
use think\facade\Db;

/**
 * 用户信息服务层
 */
class  VipService {


    /**
     * 分页查询
     */
    public static function getListByPage($type,$size, $page) {

        $where = [];
        if($type!=0){
            array_push($where,['v.type', '=', $type]);
        }

        $array = Db::name('vip')
            ->alias('v')
            ->field('v.id, v.type, v.title, v.introduce, v.sort, v.create_time, v.update_time,vt.title as vt_title')
            ->where($where)
            ->order(['v.id'=>'desc'])
            ->leftJoin('vip_type vt','v.type = vt.id')
            ->paginate([
                'list_rows' => $size,
                'page' => $page
            ]);

        // 获取图片列表
        $total = $array->total();
        $list = $array->items();

        return array('total' => $total, 'list' => $list);
    }

    /**
     * 查询会员等级 并按照各类型分组
     */
    public static function getAllVipByAllType(){
        $vipList = VipModel::select();
        $vipTypeList = VipTypeModel::select();

        $list = [];

        for ($i= 0; $i < count($vipTypeList); $i++){

            $t = array(
                'id' => $vipTypeList[$i]['id'],
                'title' => $vipTypeList[$i]['title'],
                'vips' => []
            );

            for ($j= 0; $j < count($vipList); $j++){
                if ($vipList[$j]['type'] == $vipTypeList[$i]['id']){
                    array_push($t['vips'], $vipList[$j]);
                }
            }
            if(count($t['vips'])>0){
                array_push($list, $t);
            }

        }
        return $list;
    }


}
