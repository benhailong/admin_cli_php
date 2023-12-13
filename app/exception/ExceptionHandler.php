<?php
namespace app\exception;

use think\exception\Handle;
use think\facade\Env;
use think\Response;
use Throwable;

class ExceptionHandler extends Handle {
    private $msg ="服务器异常";
    private $httpcode =500;
    private $errorcode =19999;
    public function render($request, Throwable $e): Response
    {
//        是否处于调试状态下，当处于调试状态下就返回html格式的错误信息。否则返回json格式的错误提示
        if(Env::get("APP_DEBUG")==1 && !$e->getCode())
        {
            // 其他错误交给系统处理
            return parent::render($request, $e);
        }
//        如果是服务器异常返回预先设置好的
        if($e instanceof BaseException){
            $this->msg = $e->getMessage()?:$this->msg;
            $this->httpcode = $e->getStatusCode()?:$this->httpcode;
            $this->errorcode = $e->getCode()?:$this->errorcode;
        }
//            如果是服务器异常就返回服务器异常提示
        $result_data = [
            'code'=>$this->errorcode,
            'msg'=>$this->msg,
            'data'=>[]
        ];
        return json($result_data,$this->httpcode);
    }
}