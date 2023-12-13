<?php
namespace app\admin\middleware;

use app\pub\Ants4PHP;
use app\pub\ResJson;
use think\facade\Cache;

/**
 * 接口需要判断权限
 */
class ApiRouterAuth {

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