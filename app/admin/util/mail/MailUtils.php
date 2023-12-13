<?php
namespace app\admin\util\mail;

use app\admin\service\ConfigService;
use app\exception\BaseException;
use app\pub\Ants4PHP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * @param $to
 * @param string $templete   模板
 * @param string $data   内容
 * @throws Exception
 * @describe:发送邮件
 */

class  MailUtils {

    public static function send($to,$templete="login",$data=[]){
        $mail = new PHPMailer(true); // Passing `true` enables exceptions
        try {
            // 获取 邮件 的配置
            $config = ConfigService::getInfoByKey('smtp_');
            //服务器配置
            $mail->CharSet = $config['smtp_char'];                     //设定邮件编码
            $mail->SMTPDebug = 0;                        // 调试模式输出
            $mail->isSMTP();                             // 使用SMTP
            $mail->Host = $config['smtp_host'];                // SMTP服务器
            $mail->SMTPAuth = $config['smtp_auth'] == "true";                      // 允许 SMTP 认证
            $mail->Username = $config['smtp_address'];                // SMTP 用户名  即邮箱的用户名
            $mail->Password = $config['smtp_password'];             // SMTP 密码  部分邮箱是授权码(例如qq邮箱)
            $mail->SMTPSecure = $config['smtp_secure'];                    // 允许 TLS 或者ssl协议
            $mail->Port = $config['smtp_port'];                            // 服务器端口 25 或者465 具体要看邮箱服务器支持

            $mail->setFrom($config['smtp_address'], $config['smtp_username']);  //发件人
            $mail->addAddress($to, $to);  // 收件人
            //$mail->addAddress('ellen@example.com');  // 可添加多个收件人
            $mail->addReplyTo($config['smtp_address'], $config['smtp_username']); //回复的时候回复给哪个邮箱 建议和发件人一致
            //$mail->addCC('cc@example.com');                    //抄送
            //$mail->addBCC('bcc@example.com');                    //密送

            //发送附件
            // $mail->addAttachment('1.png');         // 添加附件
            // $mail->addAttachment('../hh-1.jpg', 'lo.jpg');    // 发送附件并且重命名

            //Content
            $mail->isHTML(true);// 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
            self::template($mail, $templete, $data);
//            $mail->AltBody = '如果邮件客户端不支持HTML则显示此内容';
            $mail->send();
            Ants4PHP::log('邮件发送成功:'.$to.','.implode($data));
        } catch (Exception $e) {
            Ants4PHP::log('邮件发送失败:'.$to.','.implode($data).'，原因：'.$mail->ErrorInfo);
            throw new BaseException(400,"邮件发送失败",10001);
        }
    }

    public  static function template($mail,$templete="login",$data=[]){
        switch ($templete){
            case "login":
                $mail->Subject = '您正在使用邮件验证码登录';
                $mail->Body='
                 <div style="width: 500px; height: 400px;margin: 30px auto;">
                    <div style="text-align: center;color: #666666;">你好，您正在使用邮件验证码登录，您的验证如下</div>
                    <h1 style="text-align: center;color: #2959E3;">'.$data[0].'</h1>
                    <h3>使用注意</h3>
                    <div style="color: #666666;line-height: 24px;font-size: 14px;">1、切勿告知他人</div>
                    <div style="color: #666666;line-height: 24px;font-size: 14px;">2、如果不是您本人操作，请勿理会</div>
                    <div style="color: #666666;line-height: 24px;font-size: 14px;">3、验证码5分钟内有效，请尽快返回card.unpor.com使用</div>
                 </div>
                ';
                return $mail;
            case "register":  // 新用户注册
                $mail->Subject = '欢迎注册卡券充值系统';
                $mail->Body='
                 <div style="width: 500px; height: 400px;margin: 30px auto;">
                    <div style="text-align: center;color: #666666;">你好，您正在注册卡券充值系统，您的验证如下</div>
                    <h1 style="text-align: center;color: #2959E3;">'.$data[0].'</h1>
                    <h3>使用注意</h3>
                    <div style="color: #666666;line-height: 24px;font-size: 14px;">1、切勿告知他人</div>
                    <div style="color: #666666;line-height: 24px;font-size: 14px;">2、如果不是您本人操作，请勿理会</div>
                    <div style="color: #666666;line-height: 24px;font-size: 14px;">3、验证码5分钟内有效，请尽快返回card.unpor.com使用</div>
                 </div>
                ';
                return $mail;
            case "seekpwd":  // 找回密码
                $mail->Subject = '您正在使用密码找回功能';
                $mail->Body='
                 <div style="width: 500px; height: 400px;margin: 30px auto;">
                    <div style="text-align: center;color: #666666;">你好，您正在使用密码找回功能，您的验证如下</div>
                    <h1 style="text-align: center;color: #2959E3;">'.$data[0].'</h1>
                    <h3>使用注意</h3>
                    <div style="color: #666666;line-height: 24px;font-size: 14px;">1、切勿告知他人</div>
                    <div style="color: #666666;line-height: 24px;font-size: 14px;">2、如果不是您本人操作，请勿理会</div>
                    <div style="color: #666666;line-height: 24px;font-size: 14px;">3、验证码5分钟内有效，请尽快返回card.unpor.com使用</div>
                 </div>
                ';
                return $mail;
            case "updatePwd":  // 修改密码
                $mail->Subject = '您正在修改密码';
                $mail->Body='
                 <div style="width: 500px; height: 400px;margin: 30px auto;">
                    <div style="text-align: center;color: #666666;">你好，您正在修改密码，您的验证如下</div>
                    <h1 style="text-align: center;color: #2959E3;">'.$data[0].'</h1>
                    <h3>使用注意</h3>
                    <div style="color: #666666;line-height: 24px;font-size: 14px;">1、切勿告知他人</div>
                    <div style="color: #666666;line-height: 24px;font-size: 14px;">2、如果不是您本人操作，请勿理会</div>
                    <div style="color: #666666;line-height: 24px;font-size: 14px;">3、验证码5分钟内有效，请尽快返回card.unpor.com使用</div>
                 </div>
                ';
                return $mail;
            default:
                throw new BaseException(400,"邮件发送类型未找到",10001);
                return $mail;
        }
    }

}
