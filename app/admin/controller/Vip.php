<?php
namespace app\admin\controller;

use app\admin\model\VipModel;
use app\admin\service\VipService;
use app\BaseController;
use app\pub\ResJson;

class Vip extends BaseController {
    protected $middleware = [
//        Auth::class  => ['only' => ['getListByPage','tongji','getAgentAll'] ],
    ];

    /**
     * 分页查询
     */
    public function getAllByPage(int $type=0,int $size = 10,int  $page = 1){

        $port_list = VipService::getListByPage($type, $size, $page);
        return ResJson::success($port_list);
    }


    /**
     * 新增
     */
    public static function add(int $type, string $title, ?string $introduce, int $sort=0) {
        $model = new VipModel();
        $model->title = $title;
        $model->type = $type;
        $model->sort = $sort;
        $model->introduce = $introduce;
        $model->save();
        return ResJson::success("success");
    }

    /**
     * 删除
     */
    public function delete($id){
        // 根据id删除对应内容
        VipModel::destroy($id);
        return ResJson::success("");
    }

    /**
     * 根据id查询
     */
    public function getInfoById($id){
        // 更具id查询详情，或者返回空
        $info = VipModel::where('id',$id)->findOrEmpty();
        if ($info->isEmpty()){
            return ResJson::error("数据不存在或已经删除");
        }
        return ResJson::success($info);
    }

    /**
     * 根据id修改路由信息
     */
    public function update(int $id, int $type, string $title, ?string $introduce, int $sort=0){
        $router = VipModel::where('id',$id)->find();
        if (!$router){
            return ResJson::error("数据不存在或已经删除");
        }
        $router->type = $type;
        $router->title = $title;
        $router->introduce = $introduce;
        $router->sort = $sort;
        $router->save();
        return ResJson::success("");
    }

    /**
     * 查询会员等级
     */
    public function getAllVipByAllType(){
        $list = VipService::getAllVipByAllType();
        return ResJson::success($list);
    }

}
