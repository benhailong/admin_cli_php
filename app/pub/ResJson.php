<?php
namespace app\pub;

class ResJson {
    public static function error($msg = ''){
        $ret = array('code' => 1001, 'msg' => $msg);
//        exit(json_encode($ret));
        return json($ret);
    }

    public static function exception($msg = ''){
        $ret = array('code' => 1000, 'msg' => $msg);
//        exit(json_encode($ret));
        return json($ret);
    }

    public static function success($date){
        $ret = array('code' => 0, 'data' => $date);
        return json($ret);
//        exit(json_encode($ret));
    }

    public static function result($code = 0, $msg = '', $date = ''){
        $ret = array('code' => $code, 'msg' => $msg, 'data' => $date);
//        exit(json_encode($ret));
        return json($ret);
    }
}

