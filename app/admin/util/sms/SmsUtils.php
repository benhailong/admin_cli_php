<?php
namespace app\admin\util\sms;

use app\admin\service\ConfigService;
use app\exception\BaseException;
use app\pub\Ants4PHP;
use PHPMailer\PHPMailer\Exception;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils;

use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;

/**
 * 短信工具类
 * @param $to
 * @param string $templete   模板
 * @param string $data   内容
 * @throws Exception
 * @describe:发送邮件
 */

class  SmsUtils {

    public static function send($to,$templete="login",$data=[])
    {
        // 获取当前配置的短信的服务商
        $config = ConfigService::getInfoByKey('sms_type');

        switch ($config['sms_type']) {
            case '1':
                // 阿里云短信发送方法
                return self::aliyunsend($to, $templete, $data);
            case '2':
                // 腾讯云 短信发送方法
                return self::tencentSend($to, $templete, $data);
            default:
                throw new BaseException(400,"短信服务配置错误",10001);
        }
    }

    /**
     * 阿里云短信发送方法
     * @param $to
     * @param $templete
     * @param $data
     * @return void
     */
    public static function aliyunSend($to,$templete="register",$data=[]) {
        // 获取当前配置的短信的服务商
        $aliyun_config = ConfigService::getInfoByKey('sms_aliyun_');

        $config = new Config([
            "accessKeyId" => $aliyun_config['sms_aliyun_access_key_id'],
            "accessKeySecret" => $aliyun_config['sms_aliyun_access_key_secret'],
        ]);
        $config->endpoint = "dysmsapi.aliyuncs.com";
        $client =  new Dysmsapi($config);
        $sendSmsRequest = new SendSmsRequest([
            "phoneNumbers" => $to,
            "signName" => $aliyun_config['sms_aliyun_sign_name'],
            "templateCode" => $aliyun_config['sms_aliyun_template_'.$templete],
            "templateParam" => "{\"code\":\"".$data[0]."\"}"
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $client->sendSmsWithOptions($sendSmsRequest, $runtime);
        }
        catch (Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            // 如有需要，请打印 error
            Ants4PHP::log($error->message);
            throw new BaseException(400,$error->message,10001);
//            Utils::assertAsString($error->message);
        }
    }

    /**
     * 腾讯云短信发送方法
     */
    public static function tencentSend($to,$templete="login",$data=[]) {
        return;
    }


}
