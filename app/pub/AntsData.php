<?php
namespace app\pub;

use think\facade\Log;

/**
 * 生成唯一订单号
 */
class  AntsData {

    /**
     * 计算2个时间的时间差
     * @param $stime 开始时间 2011-12-08 07:02:40
     * @param $etime 结束时间
     * @param $unit 单位  1、秒，2、分，3、小时，4、天
     * @return string
     */
    public static function timeDifference($stime, $etime, $unit=1) {

        date_default_timezone_set("Asia/Shanghai");
        $one = strtotime($stime);//开始时间 时间戳
        $tow = strtotime($etime);//结束时间 时间戳
        $cle = $tow - $one; //得出时间戳差值
        $orderSn = $cle;
        switch($unit){
            case 2:
                $orderSn = $cle/60;
                break;
            case 3:
                $orderSn = $cle/3600;
                break;
            case 4:
                $orderSn = $cle/3600/24;
                break;
        }
        return $orderSn;
    }

    /**
     * 计算2个时间时间戳差值
     * @param $stime 开始时间 2011-12-08 07:02:40
     * @param $etime 结束时间
     * @param $unit 单位  1、秒，2、分，3、小时，4、天
     * @return string
     */
    public static function timestampDifference($stime, $etime, $unit=1) {

        date_default_timezone_set("Asia/Shanghai");
        $cle = $etime - $stime; //得出时间戳差值
        $orderSn = $cle;
        switch($unit){
            case 2:
                $orderSn = $cle/60;
                break;
            case 3:
                $orderSn = $cle/3600;
                break;
            case 4:
                $orderSn = $cle/3600/24;
                break;
        }
        return $orderSn;
    }


}
