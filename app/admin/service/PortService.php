<?php
namespace app\admin\service;

use app\admin\model\PortModel;
use think\facade\Db;

/**
 * 接口权限服务类
 */
class  PortService {

    /**
     * 查看接口详情，根据接口的地址
     */
    public static function getInfoByAddress($address) {
        $info = PortModel::where("address", $address)->findOrEmpty();
        return $info;
    }


    /**
     * 分页查询
     */
    public static function getListByPage($address,$size, $page) {

        $where = [];
        $address = str_replace(' ','',$address);
        if($address!=''){
            array_push($where,['address', 'LIKE', '%'.$address.'%']);
        }
        $array = Db::name('port')
            ->alias('p')
            ->field('p.id,p.title,p.address,p.introduce,p.router_id,p.type,r.title router_title')
            ->where('p.address','like','%'.$address.'%')
            ->order(['p.id'=>'desc'])
            ->leftJoin('router r','p.router_id = r.id')
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
     * 分页查询
     */
    public static function getAllNeedAuthAndGroupByRouterId() {

        // 查询所有需要授权的API
        $array = Db::name('port')
            ->alias('p')
            ->field('p.id,p.title,p.address,p.introduce,p.router_id,p.type,r.title router_title')
            ->order(['p.id'=>'desc'])
            ->where('p.type',2)
            ->leftJoin('router r','p.router_id = r.id')
            ->select();
        // 查询所有二级的路由列表
        $router = Db::name('router')->where('fid','>',0)->select();

        $list=[];

        for ($i=0;$i<count($router);$i++) {
            $li= ['title' => $router[$i]["title"],'id' => "router_".$router[$i]["id"],'children'=>[]];
            for ($j=0;$j<count($array);$j++) {
                if ($array[$j]["router_id"] == $router[$i]["id"]) {
                    array_push($li['children'], [
                        'id' => $array[$j]["id"],
                        'title' => $array[$j]["title"] . '-' . $array[$j]["address"],
                        'router_id' => $array[$j]["router_id"],
                        'router_title' => $array[$j]["router_title"]
                    ]);
                }
            }
            array_push($list, $li);
        }

        return $list;
    }
}
