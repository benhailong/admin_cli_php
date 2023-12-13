<?php
namespace app\admin\controller;

use app\admin\model\UsersModel;
use app\admin\util\sms\SmsUtils;
use app\BaseController;
use app\pub\AntsData;
use app\pub\ResJson;
use app\saas\controller\手机号码;
use app\saas\controller\类型，1：注册，2：修改密码;
use Overtrue\EasySms\EasySms;
use think\facade\Cache;

/**
 * 验证码
 */
class Sms extends BaseController {

    /**
     * 获取验证码
     * @param $phone 收件人邮箱地址
     * @param $type 邮件类型  login、register、seekpwd、updatePwd
     */
    public function send( $phone, $type) {
        // 先看redis是否存在
        $res = Cache::store('redis')->get('sms:phone:'.$phone.':'.$type);
        if(!empty($res)){
            // 判断时间差
            $timed = AntsData::timeDifference($res['time'], date('Y-m-d H:i:s', time()),1);
            if($timed<61){
                return ResJson::error('发送过于频繁，请稍后再试');
            }else{
                Cache::store('redis')->delete('sms:phone:'.$phone.':'.$type);
            }
        }

        // 查询邮件注册的用户
        $userInfo = UsersModel::where('phone', $phone)->findOrEmpty();

        // 判断type
        if($type=="register" && !$userInfo->isEmpty()){
            return ResJson::error("手机号码已被注册");
        }
        if($type!="register" && $userInfo->isEmpty()){
            return ResJson::error("用户不存在");
        }


        // 不存在，直接发送 或者 可以超过了1分钟
        $code= mt_rand(100000,999999); // 随机的六位验证码
        $vo = array(
            'code' => $code,
            'time' => date('Y-m-d H:i:s', time())
        );
        // 存redis
        Cache::store('redis')->set('sms:phone:'.$phone.':'.$type, $vo,300);
        SmsUtils::send($phone, $type, [$code]);

        return ResJson::success('发送成功');
    }
}
