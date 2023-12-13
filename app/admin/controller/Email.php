<?php
namespace app\admin\controller;

use app\admin\model\UsersModel;
use app\admin\util\mail\MailUtils;
use app\BaseController;
use app\pub\ResJson;
use think\facade\Cache;

class Email extends BaseController {
    protected $middleware = [
//        Auth::class  => ['only' => ['getListByPage','tongji','getAgentAll'] ],
    ];

    /**
     * 发送邮件
     * @param $toEmail 收件人邮箱地址
     * @param $type 邮件类型  login、register、seekpwd、updatePwd
     */
    public function send($toEmail, $type) {
        // 验证邮箱是否合法
        if (!filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
            return ResJson::error("邮箱地址不合法");
        }
        // 查询邮件注册的用户
        $userInfo = UsersModel::where('email', $toEmail)->findOrEmpty();

        // 判断type
        if($type=="register" && !$userInfo->isEmpty()){
            return ResJson::error("邮箱已被注册");
        }
        if($type!="register" && $userInfo->isEmpty()){
            return ResJson::error("用户不存在");
        }

        // 生成随机验证码
        $code = rand(100000, 999999);

        $vo = array(
            'code' => $code,
            'time' => date('Y-m-d H:i:s', time())
        );
        // 先删除现有的数据
        Cache::store('redis')->delete('sms:email:'.$toEmail.':'.$type);
        // 存redis
        Cache::store('redis')->set('sms:email:'.$toEmail.':'.$type, $vo, 300);
        MailUtils::send($toEmail, $type, [$code]);
        return ResJson::success("");
    }

}
