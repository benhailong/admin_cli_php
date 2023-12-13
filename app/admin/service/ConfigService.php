<?php
namespace app\admin\service;

use think\facade\Db;

/**
 * 生成唯一订单号
 */
class  ConfigService {

    /**
     * 根据关键词获取配置信息
     * @param $uniacid
     * @param $prefix
     * @return array|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getInfoByKey($prefix) {
        $where = [
            ["conf_key", "like", $prefix."%"]
        ];
        $list = Db::name('config')
            ->where($where)
            ->select();

        $data = array();
        if(count($list)==0){
            $data = '';
        }
        for ($i = 0; $i < count($list); $i++){
            $data[ $list[$i]['conf_key'] ] = $list[$i]['conf_val'];
        }
        return $data;
    }

    public static function save( $params) {
        $totol=0;
        foreach($params as $k=>$v){
            // 根据Key搜索
            $where = [
                ["conf_key", "=", $k]
            ];
            $model = Db::name('config')
                ->where($where)
                ->findOrEmpty();
            if (empty($data)){
                // 如果存在修改
                $model['conf_key'] = $k;
                $model['create_time'] = date('Y-m-d H:i:s', time());;
            }
            $model['conf_val'] = $v;
            $model['update_time'] = date('Y-m-d H:i:s', time());
            $totol = Db::name('config')->save($model);
        }
        return $totol;
    }

    /**
     * 根据前缀查看
     * @param array|string|null $uniacid
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getConfigByPrefix($prefix = ""): array
    {
        // 查询助商通的配置信息
        $where = [
            ["conf_key", "like", $prefix."%"]
        ];

        $list = Db::name('config')
            ->where($where)
            ->select();

        $data = array();
        for ($i = 0; $i < count($list); $i++) {
            $data[$list[$i]['conf_key']] = $list[$i]['conf_val'];
        }
        return $data;
    }


}
