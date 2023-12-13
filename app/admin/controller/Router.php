<?php
namespace app\admin\controller;

use app\admin\model\RouterModel;
use app\BaseController;
use app\pub\Ants4PHP;
use app\pub\ResJson;

/**
 * 路由相关
 */
class Router extends BaseController {

    /**
     * 查询所有的路由列表
     */
    public function getAllRouter($fid = -1){

        $list = [];

        if ($fid == -1){
            $list = RouterModel::order(['sort','create_time'=>'desc'])->select();
        } else {
            $list = RouterModel::where('fid',$fid)->order(['sort','id'=>'desc'])->select();
        }

        $req=[];
        for ($i=0;$i<count($list);$i++){
            if($list[$i]["fid"]==0){
                $path = [
                    'path' => $list[$i]["path"],
                    'title' => $list[$i]["title"],
                    'icon' => $list[$i]["icon"],
                    'name' => $list[$i]["name"],
                    'component' => $list[$i]["component"],
                    'id' => $list[$i]["id"],
                    'sort' => $list[$i]["sort"],
                    'fid' => $list[$i]["fid"],
                    'children' => []
                ];

                for ($j=0;$j<count($list);$j++) {
                    if ($list[$j]["fid"] == $list[$i]["id"]) {
                        array_push($path['children'], [
                            'path' => $list[$j]["path"],
                            'title' => $list[$j]["title"],
                            'icon' => $list[$j]["icon"],
                            'name' => $list[$j]["name"],
                            'component' => $list[$j]["component"],
                            'id' => $list[$j]["id"],
                            'sort' => $list[$j]["sort"],
                            'fid' => $list[$j]["fid"]
                        ]);
                    }
                }
                // 将path追加到req数组
                array_push($req, $path);
            }
        }
        return ResJson::success($req);
    }

    /**
     * 添加路由
     */
    public function addRouter($title, $path, $name, $component,$icon='', $sort=0, $fid=0){
            $router = new RouterModel();
            $router->title = $title;
            $router->path = $path;
            $router->icon = $icon;
            $router->name = $name;
            $router->component = $component;
            $router->sort = $sort;
            $router->fid = $fid;
            $router->save();
            return ResJson::success("");
    }

    /**
     * 删除
     */
    public function delete($id){
        // 判断下面是否存在子类目
        if (RouterModel::where('fid',$id)->find()){
            return ResJson::error("请先删除子类目");
        }
        // 根据id删除对应内容
        RouterModel::destroy($id);
        return ResJson::success("");
    }

    /**
     * 根据id查询
     */
    public function getInfoById($id){
        // 更具id查询详情，或者返回空
        $info = RouterModel::where('id',$id)->findOrEmpty();
        if ($info->isEmpty()){
            return ResJson::error("未找到该路由");
        }
        return ResJson::success($info);
    }

    /**
     * 根据id修改路由信息
     */
    public function update($id, $title, $path,  $name, $component,$icon='', $sort=0, $fid=0){
        $router = RouterModel::where('id',$id)->find();
        if (!$router){
            return ResJson::error("未找到该路由");
        }
        $router->title = $title;
        $router->path = $path;
        $router->icon = $icon;
        $router->name = $name;
        $router->component = $component;
        $router->sort = $sort;
        $router->fid = $fid;
        $router->save();
        return ResJson::success("");
    }


}
