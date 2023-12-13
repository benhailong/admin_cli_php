<?php

namespace app\controller;

use app\BaseController;

class Index extends BaseController
{
    public function index()
    {
        return 'hello,unpor!';
    }

    public function hello($name = 'unpor')
    {
        return 'hello,' . $name;
    }
}
