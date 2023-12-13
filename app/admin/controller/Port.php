<?php
namespace app\admin\controller;

use app\admin\model\PortModel;
use app\admin\service\PortService;
use app\BaseController;
use app\pub\ResJson;
use think\facade\Db;

/**
 * 接口管理
 */
class Port extends BaseController {

    /**
     * 查询所有的接口列表
     */
    public function getAll($address = '',$size = 10, $page = 1){
        $port_list = PortService::getListByPage($address,$size, $page);
        return ResJson::success($port_list);
    }

    /**
     * 添加接口
     */
    public function add($title, $address,  $router_id,$type,$introduce=''){
        $port = new PortModel();
        $port->title = $title;
        $port->address = $address;
        $port->router_id = $router_id;
        $port->type = $type;
        $port->introduce = $introduce;
        $port->save();
        return ResJson::success("");
    }

    /**
     * 删除
     */
    public function delete($id){
        // 根据id删除对应内容
        PortModel::destroy($id);
        return ResJson::success("");
    }

    /**
     * 根据id查询
     */
    public function getInfoById($id){
        // 更具id查询详情，或者返回空
        $info = PortModel::where('id',$id)->findOrEmpty();
        if ($info->isEmpty()){
            return ResJson::error("未找到该接口");
        }
        return ResJson::success($info);
    }

    /**
     * 根据id修改路由信息
     */
    public function update($id, $title, $address,  $router_id,$type,$introduce=''){
        $router = PortModel::where('id',$id)->find();
        if (!$router){
            return ResJson::error("未找到该接口");
        }
        $router->title = $title;
        $router->address = $address;
        $router->router_id = $router_id;
        $router->type = $type;
        $router->introduce = $introduce;
        $router->save();
        return ResJson::success("");
    }

    /**
     * 查询所有需要授权才能访问的接口列表,并更具路由id进行分组
     */
    public function getAllNeedAuthAndGroupByRouterId(){
        return ResJson::success(PortService::getAllNeedAuthAndGroupByRouterId());
    }

}
