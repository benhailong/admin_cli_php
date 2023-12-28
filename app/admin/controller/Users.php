<?php
namespace app\admin\controller;

use app\admin\model\UsersModel;
use app\admin\model\UsersVipModel;
use app\admin\service\UsersService;
use app\BaseController;
use app\pub\Ants4PHP;
use app\pub\ResJson;
use think\facade\Cache;
use think\facade\Db;
use think\Request;

class Users extends BaseController {
    protected $middleware = [
//        Auth::class  => ['only' => ['getListByPage','tongji','getAgentAll'] ],
    ];

    /**
     * 用户注册 邮箱
     * @param $email
     * @param $password
     * @param $code
     * @return \think\response\Json
     */
    public function register_email( $email, $password, $code) {
        // 校验邮箱是否正确
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ResJson::error("邮箱地址不合法");
        }

        // 验证验证码
        $res = Cache::store('redis')->get('sms:email:'.$email.':register');
        if(empty($res)){
            return ResJson::error('验证码已失效');
        }
        if($code != $res['code']){
            return ResJson::error('验证码输入错误');
        }

        $vo = UsersModel::where('email', $email)->findOrEmpty();

        if(!$vo->isEmpty()){
            // 不为空，返回错误，提示已经注册
            return ResJson::error('该邮箱已注册');
        }
        // 随机生成yan
        $yan = substr(md5(time()), 0, 8);
        $password = md5($password.$yan);

        // 启动事务
        Db::startTrans();

        try {
            $user = new UsersModel();
            $user->email = $email;
            $user->password = $password;
            $user->yan = $yan;
            $user->app_id = 'up'.Ants4PHP::ant_order();
            $user->app_secret = Ants4PHP::ant_uuid();
            $user->username = substr(md5(time()), 10, 8);  // 随机生成用户名
            $user->role_id = 2;
            $user->status = 1;
            $user->save();

            Db::commit();

            // 验证码校验成功，删除验证码
            Cache::store('redis')->delete('sms:email:'.$email.':register');

            return ResJson::success('注册成功');
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return ResJson::error($e->getMessage());
        }
        return ResJson::error("注册失败");

    }

    /**
     * 用户注册 手机号码
     * @param $email
     * @param $password
     * @param $code
     * @return \think\response\Json
     */
    public function register_phone( $phone, $password, $code) {
        // 校验手机号格式是否正确
        if (!preg_match("/^1[3-9]\d{9}$/", $phone)) {
            return ResJson::error("手机号码不合法");
        }

        // 验证验证码
        $res = Cache::store('redis')->get('sms:phone:'.$phone.':register');
        if(empty($res)){
            return ResJson::error('验证码已失效');
        }
        if($code != $res['code']){
            return ResJson::error('验证码输入错误');
        }

        $vo = UsersModel::where('phone', $phone)->findOrEmpty();

        if(!$vo->isEmpty()){
            // 不为空，返回错误，提示已经注册
            return ResJson::error('该手机号码已注册');
        }
        // 随机生成yan
        $yan = substr(md5(time()), 0, 8);
        $password = md5($password.$yan);

        // 启动事务
        Db::startTrans();

        try {
            $user = new UsersModel();
            $user->phone = $phone;
            $user->password = $password;
            $user->yan = $yan;
            $user->app_id = 'up'.Ants4PHP::ant_order();
            $user->app_secret = Ants4PHP::ant_uuid();
            $user->username = substr(md5(time()), 10, 8);  // 随机生成用户名
            $user->role_id = 2;
            $user->status = 1;
            $user->save();

            Db::commit();

            // 验证码校验成功，删除验证码
            Cache::store('redis')->delete('sms:phone:'.$phone.':register');

            return ResJson::success('注册成功');
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return ResJson::error($e->getMessage());
        }
        return ResJson::error("注册失败");

    }


    /**
     * 忘记密码 邮箱
     * @param $email
     * @param $password
     * @param $code
     * @return \think\response\Json
     */
    public function seekpwd_email( $email, $password, $code) {
        // 校验邮箱是否正确
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ResJson::error("邮箱地址不合法");
        }

        // 验证验证码
        $res = Cache::store('redis')->get('sms:email:'.$email.':seekpwd');
        if(empty($res)){
            return ResJson::error('验证码已失效');
        }
        if($code != $res['code']){
            return ResJson::error('验证码输入错误');
        }

        $vo = UsersModel::where('email', $email)->findOrEmpty();

        if($vo->isEmpty()){
            // 不为空，返回错误，提示已经注册
            return ResJson::error('该邮箱未注册');
        }
        // 随机生成yan
        $yan = substr(md5(time()), 0, 8);
        $password = md5($password.$yan);

        $updateInfo = [
            "password" => $password,
            "yan" => $yan,
        ];

        UsersModel::update($updateInfo,["id"=>$vo->id]);
        // 验证码校验成功，删除验证码
        Cache::store('redis')->delete('sms:email:'.$email.':seekpwd');

        return ResJson::success('修改密码成功');

    }

    /**
     * 忘记密码 手机号码
     * @param $email
     * @param $password
     * @param $code
     * @return \think\response\Json
     */
    public function seekpwd_phone( $phone, $password, $code) {
        // 校验手机号格式是否正确
        if (!preg_match("/^1[3-9]\d{9}$/", $phone)) {
            return ResJson::error("手机号码不合法");
        }

        // 验证验证码
        $res = Cache::store('redis')->get('sms:phone:'.$phone.':seekpwd');
        if(empty($res)){
            return ResJson::error('验证码已失效');
        }
        if($code != $res['code']){
            return ResJson::error('验证码输入错误');
        }

        $vo = UsersModel::where('phone', $phone)->findOrEmpty();

        if($vo->isEmpty()){
            // 不为空，返回错误，提示已经注册
            return ResJson::error('该手机号码未注册');
        }
        // 随机生成yan
        $yan = substr(md5(time()), 0, 8);
        $password = md5($password.$yan);

        // 启动事务
        $updateInfo = [
            "password" => $password,
            "yan" => $yan,
        ];

        UsersModel::update($updateInfo,["id"=>$vo->id]);
        // 验证码校验成功，删除验证码
        Cache::store('redis')->delete('sms:phone:'.$phone.':seekpwd');
        return ResJson::success('修改密码成功');
    }

    /**
     * 用户登录
     * @param Request $request
     * @param $username
     * @param $password
     * @return \think\response\Json
     */
    public function login( $username, $password, $code, $key) {

        // 验证账号不能既不是手机号也不是邮箱地址
        if (!filter_var($username, FILTER_VALIDATE_EMAIL) &&!preg_match("/^1[3-9]\d{9}$/", $username)) {
            return ResJson::error("账号不合法");
        }


        if(empty($key)){
            return ResJson::error('参数错误');
        }
        $res = Cache::store('redis')->get('code:'.$key);
        if(empty($res)){
            return ResJson::error('验证码已失效');
        }
        if($code != $res){
            return ResJson::error('验证码不正确');
        }
        // 验证码校验成功，删除验证码
        Cache::store('redis')->delete('code:'.$key);

        // 验证用户名密码
        $vo = UsersModel::whereOr([['phone', '=', $username],['email', '=', $username]])->findOrEmpty();

//        return ResJson::exception($vo);

        if($vo->isEmpty()){
            // 为空，二姐返回错误
            return ResJson::exception('账号不存在');
        }
        if($vo->status != 1){
            // 为空，二姐返回错误
            return ResJson::exception('账号异常，请联系管理员');
        }

        // 检查密码是否正确
        if($vo->password != md5($password.$vo->yan) ){
            return ResJson::exception('用户名密码不匹配');
        }

        // 匹配正确，生成 token 将数据存到redis
        $token = Ants4PHP::ant_uuid();
        // 新版本token
        $userLoginInfoReq =  $vo->toArray();
        $userLoginInfoReq["token"] = $token;
        Cache::store('redis')->set('user:'.$vo->id, $userLoginInfoReq, 3000);

        $vo->update_time = date('Y-m-d H:i:s',time());
        $vo->save();

        $res = array('token' => $token."&".$vo->id,
            'username' => $vo->username);

        return ResJson::success($res);
    }

    /**
     * 退出
     */
    public function loginout( Request $request ) {
        Cache::store('redis')->delete('user:'.$request->userid);
        return ResJson::success('退出登录成功');
    }


    // 根据用户所在的角色，找出所有的路由
    public function getRoutesByRole( Request $request ) {
        $role_id = $request->role_id;
        // 查询所有列表
        $list = Db::name('role_router')
            ->alias('rr')
            ->field('ro.id,ro.title,ro.name,ro.path,ro.icon,ro.fid,ro.sort,ro.component')
            ->where('rr.role_id',1)
            ->leftJoin('router ro','rr.router_id = ro.id')
            ->order('ro.sort', 'desc')
            ->select();

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
     * 分页查询
     */
    public function getAllByPage($username = '',$phone = '',$email = '',$size = 10, $page = 1){
        $port_list = UsersService::getListByPage($username,$phone,$email,$size, $page);
        return ResJson::success($port_list);
    }


    /**
     * 给用户开通会员权限
     */
    public function setVip(int $user_id, string $vips){
        UsersService::setVip($user_id,$vips);
        return ResJson::success("");
    }

    /**
     * 查询用户的所有权限
     */
    public static function getVipByUserId(int $user_id){
        $list = UsersVipModel::where("user_id",$user_id)->select();
        return ResJson::success($list);
    }

    /**
     * 修改用户状态
     */
    public static function setStatus(int $user_id,int $status){
        if($user_id==1){
            return ResJson::success("初始账号禁止警用");
        }
        UsersModel::update(['status' => $status], ['id' => $user_id]);
        return ResJson::success("");
    }


    /**
     * 根据用户的ID获取用户的详细信息
     */
    public static function getInfoById(int $user_id){
        $user = UsersModel::where("id",$user_id)->findOrEmpty();
        return ResJson::success($user);
    }

}
