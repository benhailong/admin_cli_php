<?php
namespace app\admin\middleware;

use app\admin\service\PortService;
use app\pub\Ants4PHP;
use app\pub\ResJson;
use think\facade\Cache;
use think\facade\Db;

/**
 * 判断登录中间键
 */
class Islogin {

    // 不需要登录的url
    public static $notLoginUrl = [
        "email/send",
        "sms/send",
        "captcha/create",
        "users/login",
        "users/register_email",
        "users/register_phone",
        "users/seekpwd_email",
        "users/seekpwd_phone"
    ];


    public function handle($request, \Closure $next){
        // 判断字符在否在数组中
        if(!in_array($request->pathinfo(), self::$notLoginUrl)){
            // 如果是登录，直接过去
            if(empty($request->header('token'))){
                // 不存在token，直接返回
                return ResJson::result('10002', '请先登录');
            }
            // 存在token
//            $res = Cache::store('redis')->get('user-'.$request->header('token'));
            // 新版token
            $token = $request->header('token');
            $tokenArr = explode('&',$token);
            if(count($tokenArr)<2){
                return ResJson::result('10002', '登录超时');
            }
            $res = Cache::store('redis')->get('user:'.$tokenArr[1]);

            if(empty($res)){
                // 登录已经过期
                return ResJson::result('10002', '登录超时');
            }
//            Ants4PHP::log('token='.$tokenArr[0]);
//            Ants4PHP::log('session='.$request->header("session"));
//            if($res['token']!=$tokenArr[0] || $res['fingerprint'] != $request->header("session")){
            if($res['token']!=$tokenArr[0]){
                return ResJson::result('10002', '您已被踢出');
            }

//            // 根据当前的地址，查询接口的详细信息
            $port_info = PortService::getInfoByAddress($request->pathinfo());

            if($port_info->isEmpty()){
                return ResJson::result('10000', '接口不存在');
            }elseif($port_info['type'] === 2){
                // 不光需要登录，还需要权限
                $port_list = Db::name('port')
                    ->field('address')
                    ->where('address',$request->pathinfo())
                    ->select();

                $role_id = $res['role_id'];
                $port_list = Db::name('role_port')
                    ->alias('rp')
                    ->field('p.address')
                    ->where('rp.role_id',$role_id)
                    ->leftJoin('port p','rp.port_id = p.id')
                    ->select();
                $role_port_list = [];
                foreach($port_list as $k => $v){
                    array_push($role_port_list, $v['address']);
                }
                // 获取当前请丢的
                if(!in_array($request->pathinfo(), $role_port_list)){
                    // 如果不包含，说明没有权限，直接返回错误
                    return ResJson::result('10000', '权限不足');
                }
            }
            // 更新登录的过期时间
            Cache::store('redis')->set('user:'.$tokenArr[1], $res, 3000);
            // 管理用户的唯一ID传给控制器
            $request->userid = $res['id'];
            $request->vip_level = $res['vip_level'];
            $request->role_id = $res['role_id'];
            return $next($request);
        }else{
            // 不需要验证的接口，直接通过
            return $next($request);
        }

    }
}