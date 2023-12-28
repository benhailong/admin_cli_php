<?php
namespace app\admin\service;

use app\admin\model\PortModel;
use app\admin\model\UsersVipModel;
use think\facade\Db;

/**
 * 用户信息服务层
 */
class  UsersService {


    /**
     * 分页查询
     */
    public static function getListByPage($username,$phone,$email,$size, $page) {

        $where = [];
        $username = str_replace(' ','',$username);
        $phone = str_replace(' ','',$phone);
        $email = str_replace(' ','',$email);
        if($username!=''){
            array_push($where,['username', 'LIKE', '%'.$username.'%']);
        }
        if($phone!=''){
            array_push($where,['phone', 'LIKE', '%'.$phone.'%']);
        }
        if($email!=''){
            array_push($where,['email', 'LIKE', '%'.$email.'%']);
        }
        $array = Db::name('users')
            ->alias('u')
            ->field('u.id,u.phone,u.email,u.username,u.create_time,u.role_id,u.status,r.name role_name,r.introduce role_introduce')
            ->where($where)
            ->order(['u.id'=>'desc'])
            ->leftJoin('role r','u.role_id = r.id')
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

    /**
     * 给用户开通会员权限
     */
    public static function setVip(int $user_id, string $vips){
        // json字符串转数组
        $vip_list = json_decode($vips,true);

        // 先删除用户的所有权限
        UsersVipModel::where('user_id',$user_id)->delete();
        $user_vip = new UsersVipModel;
        $list = [];

        for ($i=0;$i<count($vip_list);$i++) {
            array_push($list, [
                'user_id'=>$user_id,
                'vip_id'=>$vip_list[$i]["vip"],
                'vip_expire_time'=>$vip_list[$i]["expire_time"],
                'vip_type_id'=>$vip_list[$i]["vip_type_id"]
            ]);
        }
//        print_r($list);
        $user_vip->saveAll($list);
        return true;
    }


}
