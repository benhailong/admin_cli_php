<?php
// 全局中间件定义文件
return [
    // 全局请求缓存
    // \think\middleware\CheckRequestCache::class,
    // 多语言加载
    // \think\middleware\LoadLangPack::class,
    // Session初始化
    // \think\middleware\SessionInit::class

    // 后台接口中间键，用于判断是否登录
    \app\admin\middleware\Islogin::class,
    // 支持跨域
    \app\admin\middleware\MyAllowCrossDomain::class
//    'alias' => [
//        'auth' => app\saas\middleware\Auth::class,
//    ],
];
