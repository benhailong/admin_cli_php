<?php

declare (strict_types=1);

namespace app\admin\controller;


use app\BaseController;
use app\pub\Ants4PHP;
use app\pub\ResJson;
use think\facade\Cache;

/**
 * 验证码
 */

class Captcha extends BaseController{

    public static function create( $ttl = 300){
        try {
            $width = 200;
            $height = 95;
            $image = imagecreatetruecolor($width, $height); // 设置画布的大小
            $bjColor = imagecolorallocate($image, 250, 250, 250);  // 设置画布背景色
            imagefill($image, 0, 0, $bjColor); // 填充画布

            $coderCount = 4;
//            $coder = Str::random($coderCount, 1);
            $coder = Ants4PHP::getRandStr(4);
            for ($a = 0; $a < $coderCount; $a++) {
                $textColor = imagecolorallocate($image, rand(180, 215), rand(180, 215), rand(210, 233));  // 设置验证码字符颜色
                imagettftext(  // 绘制验证码字符
                    $image, // 绘制位置
                    36, // 字体大小
                    rand(20, -20), // X 轴偏移角度
                    30 + 40 * $a, // 设置字符间隔
                    rand(55, 65), // Y 轴字体偏移角度
                    $textColor, // 字体颜色
                    root_path() . '/static/font/mlfsjt.ttf',
                    $coder[$a] // 验证码字符
                );
            }
            imagejpeg($image);
            $content = ob_get_clean();
            imagedestroy($image);
            $base64 = "data:image/jpeg;base64," . base64_encode($content);

            $key = Ants4PHP::ant_uuid() . time();
            Cache::set('code:'.$key, $coder, $ttl);
//            Cache::store('redis')->set('code:'.$key, $coder, 300);

            return ResJson::success(['key'=>$key,'codeimg'=>$base64]);
        } catch (\Exception $e) {
            return  ResJson::error('create failed') ;
        }
    }
}