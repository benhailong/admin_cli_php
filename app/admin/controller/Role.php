<?php
namespace app\admin\controller;

use app\admin\model\RoleModel;
use app\admin\model\RolePortModel;
use app\admin\model\RoleRouterModel;
use app\admin\model\UsersModel;
use app\admin\service\RoleService;
use app\admin\util\mail\MailUtils;
use app\BaseController;
use app\pub\ResJson;
use think\facade\Cache;

/**
 * 权限相关
 */
class Role extends BaseController {

    /**
     * 查询所有的角色列表
     */
    public function getAll($keywords = '',$size = 10, $page = 1){
        $port_list = RoleService::getListByPage($keywords,$size, $page);
        return ResJson::success($port_list);
    }

    /**
     * 添加
     */
    public function add($name, $label,$introduce=''){
        $port = new RoleModel();
        $port->name = $name;
        $port->label = $label;
        $port->introduce = $introduce;
        $port->save();
        return ResJson::success("");
    }

    /**
     * 删除
     */
    public function delete($id){
        // 根据id删除对应内容
        RoleModel::destroy($id);
        return ResJson::success("");
    }

    /**
     * 根据id查询
     */
    public function getInfoById($id){
        // 更具id查询详情，或者返回空
        $info = RoleModel::where('id',$id)->findOrEmpty();
        if ($info->isEmpty()){
            return ResJson::error("未找到该角色");
        }
        return ResJson::success($info);
    }

    /**
     * 根据id修改路由信息
     */
    public function update($id, $name, $label,$introduce=''){
        $router = RoleModel::where('id',$id)->find();
        if (!$router){
            return ResJson::error("未找到该接口");
        }
        $router->name = $name;
        $router->label = $label;
        $router->introduce = $introduce;
        $router->save();
        return ResJson::success("");
    }

    /**
     * 根据角色ID，获取已经有的所有路由
     */
    public function getRouterByRoleId($role_id){
        $router = RoleRouterModel::where('role_id',$role_id)->select();
        // 遍历，并将里边的router_id,拼接成数组
        $router_id=[];
        for ($i=0;$i<count($router);$i++){
            array_push($router_id,$router[$i]["router_id"]);
        }
        return ResJson::success($router_id);
    }



    /**
     * 根据角色ID，保存已经有的所有路由
     */
    public function saveRouterByRoleId($role_id,$routers){
        // 遍历所有routers
        $rrm = new RoleRouterModel();
        $list=[];
        for ($i=0;$i<count($routers);$i++){
            array_push($list,['role_id'=>$role_id,'router_id'=>$routers[$i]]);
        }
        // 根据role删除
        RoleRouterModel::where('role_id','=',$role_id)->delete();
        $rrm->saveAll($list);
        return ResJson::success('');
    }


    /**
     * 根据角色ID，获取已经有的所有接口
     */
    public function getPortByRoleId($role_id){
        $port = RolePortModel::where('role_id',$role_id)->select();
        // 遍历，并将里边的router_id,拼接成数组
        $port_id=[];
        for ($i=0;$i<count($port);$i++){
            array_push($port_id,$port[$i]["port_id"]);
        }
        return ResJson::success($port_id);
    }



    /**
     * 根据角色ID，保存已经有的所有路由
     */
    public function savePortByRoleId($role_id,$ports){
        // 遍历所有routers
        $rrm = new RolePortModel();
        $list=[];
        for ($i=0;$i<count($ports);$i++){
            array_push($list,['role_id'=>$role_id,'port_id'=>$ports[$i]]);
        }
        // 根据role删除
        RolePortModel::where('role_id','=',$role_id)->delete();
        $rrm->saveAll($list);
        return ResJson::success('');
    }

    /**
     * 查询所有的角色列表-不分页
     */
    public function getAllNoPage(){
        $list = RoleModel::select();
        return ResJson::success($list);
    }


}
