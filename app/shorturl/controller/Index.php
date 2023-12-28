<?php

namespace app\shorturl\controller;

use app\BaseController;

class Index extends BaseController
{
    public function index($name = 'unpor')
    {
        if($name=="unpor"){
            Header("Location:http://www.baidu.com");
        }
        return 'hello,'.$name;
    }

    public function hello($name = 'unpor')
    {
        return 'hello,' . $name;
    }
}
