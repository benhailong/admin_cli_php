<?php
namespace app\admin\controller;

use app\pub\ResJson;
use app\admin\service\ConfigService;
use think\Request;

error_reporting(0);

class Config {


    /**
     * 根据前缀查询配置信息
     * @param Request $request
     * param prefix 配置项目前缀,自动添加下划线
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getInfoByKey(Request $request, $key = ""){
        $data = ConfigService::getInfoByKey($key);
        return ResJson::success($data);
    }

    /**
     * 保存 或者 修改 数据
     * @param Request $request
     */
    public function save(Request $request){
        $params = $request->param();
        ConfigService::save( $params);
        return ResJson::success('');
    }

    /**
     * 保存 或者 修改 数据
     * @param Request $request
     */
    public function getPiceConf(Request $request){
        $type = ConfigService::getInfoByKey('zst_type');
        $addpice = ConfigService::getInfoByKey( 'zst_addpice');
        $data = [
            'type' => $type['zst_type'],
            'addpice' => $addpice['zst_addpice']
        ];
        return ResJson::success($data);
    }

}
