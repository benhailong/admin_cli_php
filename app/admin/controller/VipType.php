<?php
namespace app\admin\controller;

use app\admin\model\VipModel;
use app\admin\model\VipTypeModel;
use app\admin\service\VipService;
use app\admin\service\VipTypeService;
use app\BaseController;
use app\pub\ResJson;

class VipType extends BaseController {
    protected $middleware = [
//        Auth::class  => ['only' => ['getListByPage','tongji','getAgentAll'] ],
    ];

    /**
     * 分页查询
     */
    public function getAllByPage(int $size = 10,int  $page = 1){
        $port_list = VipTypeService::getListByPage( $size, $page);
        return ResJson::success($port_list);
    }


    /**
     * 新增
     */
    public static function add(string $title) {
        $model = new VipTypeModel();
        $model->title = $title;
        $model->save();
        return ResJson::success("success");
    }

    /**
     * 删除
     */
    public function delete($id){
        // 根据id删除对应内容
        VipTypeModel::destroy($id);
        return ResJson::success("");
    }

    /**
     * 根据id查询
     */
    public function getInfoById($id){
        // 更具id查询详情，或者返回空
        $info = VipTypeModel::where('id',$id)->findOrEmpty();
        if ($info->isEmpty()){
            return ResJson::error("数据不存在或已经删除");
        }
        return ResJson::success($info);
    }

    /**
     * 根据id修改路由信息
     */
    public function update($id, $title){
        $router = VipTypeModel::where('id',$id)->find();
        if (!$router){
            return ResJson::error("数据不存在或已经删除");
        }
        $router->title = $title;
        $router->save();
        return ResJson::success("");
    }

    /**
     * 获取所有会员类型
     */
    public function getAll(){
        $list = VipTypeModel::select();
        return ResJson::success($list);
    }

}
