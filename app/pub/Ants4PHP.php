<?php
namespace app\pub;

use app\saas\model\ImgModel;
use think\facade\Filesystem;
use think\facade\Log;
use think\File;

/**
 * 生成唯一订单号
 */
class  Ants4PHP
{
    public static function ant_order()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K');
        $orderSn = strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }

    public static function getRandStr($length){
        //字符组合
//        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '0123456789';
        $len = strlen($str)-1;
        $randstr = '';
        for ($i=0;$i<$length;$i++) {
            $num=mt_rand(0,$len);
            $randstr .= $str[$num];
        }
        return $randstr;
    }

    public static function ant_password($length = 8, $have_special = true)
    {
        // 密码字符集，可任意添加你需要的字符
        $chars = $have_special?
            'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|'
            : 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $password = '';
        for ( $i = 0; $i < $length; $i++ ) {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        return $password;
    }

    /**
     * UUID 生成工具
     */
    public static function ant_uuid()
    {
        $chars = md5(uniqid(mt_rand(), true));
        $uuid = substr($chars, 0, 8) . '-'
            . substr($chars, 8, 4) . '-'
            . substr($chars, 12, 4) . '-'
            . substr($chars, 16, 4) . '-'
            . substr($chars, 20, 12);
        return $uuid;
    }

    /**
     * 返回 json 值
     * @param int $code
     * @param null $msg
     * @param null $data
     */
    public static function ant_return_json($code = 0, $msg = '', $data = '')
    {
        $ret = array('code' => $code, 'msg' => $msg, 'data' => $data);
        exit(json_encode($ret));
    }

    /**
     * 删除空格，清楚文件中的空格和空字符串
     */
    public static function ant_remove_null($str)
    {
        $oldchar = array(" ", "　", "\t", "\n", "\r");
        $newchar = array("", "", "", "", "");
        return str_replace($oldchar, $newchar, $str);
    }

    /**
     * ASCII排序
     */
    public static function ant_ASCII($params = array())
    {
        if (!empty($params)) {
            $p = ksort($params);
            if ($p) {
                $str = '';
                foreach ($params as $k => $val) {
                    $str .= $k . '=' . $val . '&';
                }
                $strs = rtrim($str, '&');
                return $strs;
            }
        }
        return '参数错误';
    }

    public static function log($data, $path=''){
        $time = date('Y-m-d H:i:s', time());
        if($path==""){
            $path = app('http')->getName().'/'.app('request')->controller().'/'.app('request')->action();
        }
//        $msg = "[".$time."] - Path: ".$path." - Msg: ".json_encode($data,JSON_UNESCAPED_UNICODE)." - File：".__FILE__." - Line：".__LINE__;
        $debugInfo = debug_backtrace();
        $path = "Path: " . $path;
        $msg = "msg: " . json_encode($data,JSON_UNESCAPED_UNICODE);
        $info = "info: " . $debugInfo[0]['file']. ' ('.$debugInfo[0]['line'].')';
//        Log::antlog("-----------------开始时间--".$time."-------------------");
        Log::antlog($time."-------------------".PHP_EOL.$path.PHP_EOL.$info.PHP_EOL.$msg);
//        Log::antlog("-----------------结束时间--".$time."-------------------");
    }

    /**
     * 发送post请求
     * @param string $url 请求地址
     * @param array $post_data post键值对数据
     * @return string
     */
    public static function post($url, $post_data) {
        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            ),
            "ssl" => [
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ]
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result, true);
        return $result;
    }

    public static function http_post_json($url, $dataArray, $cookie=''){
        $jsonStr = json_encode($dataArray);

        $header =  array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($jsonStr)
        );

        if($cookie!=''){
//            $header['cookie'] = $cookie;
            array_push($header, 'cookie: '.$cookie);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return array($httpCode, $response);
    }

    public static function http_get_json($url, $dataArray){
        if(!empty($dataArray)){
            $url .= "?";
            foreach($dataArray as $key => $value) {
                if($value != end($dataArray)){
                    $url .= $key ."=". $value."&amp;";
                } else {
                    $url .= $key ."=". $value;
                }
            }
        }
//        print_r($url);
        return self::get($url);
    }

    public static function get($url) {
        $stream_opts = [
            "ssl" => [
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ]
        ];

        $s = file_get_contents($url,false, stream_context_create($stream_opts));
        $s = json_decode($s, true);
        return $s;
    }

    public static function my_filtr($arr) {
        if($arr === '' || $arr === null){
            return false;
        }
        return true;
    }



    public static function getZstSign($params, $secret){
        unset($params["sign"]);
        ksort($params);
        $str ='';
        $index=1;
        foreach($params as $key => $value) {
//            if(count($params) > $index){
//                $str .= $key ."=". $value."&amp;";
//            } else {
//                $str .= $key ."=". $value;
//            }
            $str .= $key . $value;
            $index++;
        }
        $str .= $secret;
        $sign = md5($str);
        return $sign;
    }

    // 获取url的html内容，携带cookie
    public static function get_html_content($url, $cookie = '') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    // 根据dom标签，获取html中的值
    public static function get_html_value($html, $dom) {
        $dom = str_replace('.', '\.', $dom);
        $pattern = '/<'.$dom.'>(.*?)<\/'.$dom.'>/';
        preg_match($pattern, $html, $matches);
        return isset($matches[1]) ? $matches[1] : '';
    }

    // 在html中，根据meta的property获取的content值
    public static function get_html_meta_content($html, $property) {
        $pattern = '/<meta\s+property="'.$property.'"\s+content="(.*?)"\s*\/>/';
        preg_match($pattern, $html, $matches);
        return isset($matches[1]) ? $matches[1] : '';
    }

    // 查看html中是否存在某个字符
    public static function is_html_contain($html, $str) {
        $pattern = '/'.$str.'/';
        preg_match($pattern, $html, $matches);
        return isset($matches[0]) ? true : false;
    }

    /**
     * 远程图片 下载 到本地
     * @param $url 远程图片 url
     * @param $filePath 保存本地路径
     * @param bool $public_path 是否存放在 获取web根目录 下 即 public 下
     * @return bool|int
     */
    public static function img_down_local($url,$filePath,$public_path = true){
        $root = '';
        //pathinfo($url, PATHINFO_BASENAME); //远程图片名称及后缀

        if ($public_path == true){
            $root =  rtrim(rtrim(public_path(),'/'),'\\');
        }

        $path = $root.$filePath;
        if (!file_exists(dirname($path))){
            mkdir(dirname($path),0777,true);
        }
        $content = file_get_contents($url);
        return file_put_contents($path,$content);
    }

    /**
     * 本地图片 上传到 阿里云OSS
     * @param $url 本地图片的路径
     * @return bool|int
     */
    public static function img_to_alioss($url,$userid,$public_path = true){
        $root = '';
        if ($public_path == true){
            $root =  rtrim(rtrim(public_path(),'/'),'\\');
        }
        $savename =  Filesystem::disk('aliyun')->putFile('topic1',new File($root.$url));
        // 保存到数据库
        // 保存到数据库
        $params['name'] = pathinfo($url, PATHINFO_BASENAME);
        $params['url'] = $savename;
        $params['user_id'] = 7;
        $params['img_type'] = 1;
        $params['box_id'] =7;
        $size = getimagesize($root.$url);
        $params['width'] = $size[0];
        $params['hight'] = $size[1];

        $model = new ImgModel();
        $model->save($params);


        self::del_file($root.$url);
        return $savename;
    }

    // 根据路径删除文件
    public static function del_file($path){
        if (file_exists($path)){
            unlink($path);
        }
    }

    /**
     * 根据标签信息，获取内容
     * $html-需要爬取的页面内容
     * $tag-要查找的标签
     * $attr-要查找的属性名
     * $value-属性名对应的值
     */
    public function get_tag_data($html,$tag,$attr,$value){
        $regex = "/<$tag.*?$attr=\".*?$value.*?\".*?>(.*?)<\/$tag>/is";
        preg_match_all($regex,$html,$matches,PREG_PATTERN_ORDER);
        return $matches[1];
    }

}
