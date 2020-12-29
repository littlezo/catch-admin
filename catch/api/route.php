<?php
// +----------------------------------------------------------------------
// | CatchAdmin [Just Like ～ ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017~{$year} http://catchadmin.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( https://github.com/yanwenwu/catch-admin/blob/master/LICENSE.txt )
// +----------------------------------------------------------------------
// | Author: JaguarJack [ njphper@gmail.com ]
// +----------------------------------------------------------------------

// you should use `$router`
$router->group(function () use ($router) {
    // user路由
    $router->post('api/user/login', '\catchAdmin\api\controller\User@login');
    $router->post('api/user/register', '\catchAdmin\api\controller\User@register');
    $router->post('api/user/retrieve', '\catchAdmin\api\controller\User@retrieve');
    // config路由
    $router->post('api/getCode', '\catchAdmin\api\controller\Config@getCode');
    $router->get('api/config/hall', '\catchAdmin\api\controller\Config@getHall');
    $router->get('api/config', '\catchAdmin\api\controller\Config@index');
    $router->get('api/getConfig/:id', '\catchAdmin\api\controller\Config@read');
});
$router->group(function () use ($router) {
    // user路由
    $router->delete('api/user/logout', '\catchAdmin\api\controller\User@logout');
    $router->post('api/user/refresh', '\catchAdmin\api\controller\User@refreshToken');
    $router->get('api/user/info', '\catchAdmin\api\controller\User@read');
    $router->post('api/user/update', '\catchAdmin\api\controller\User@update');
    $router->post('api/user/modify', '\catchAdmin\api\controller\User@modifyPassword');
    // goods路由
    $router->get('api/goods/list', '\catchAdmin\api\controller\Goods@list');
    $router->resource('api/goods', '\catchAdmin\api\controller\Goods');
    // order路由
    $router->resource('api/order', '\catchAdmin\api\controller\Order');
    // account路由
    $router->resource('api/account', '\catchAdmin\api\controller\Account');
    // level路由
    $router->get('api/level/list', '\catchAdmin\api\controller\Level@index');
    $router->resource('api/level', '\catchAdmin\api\controller\Level');
    // recharge路由
    $router->resource('api/recharge', '\catchAdmin\api\controller\Recharge');
    // withdrawal路由
    $router->resource('api/withdrawal', '\catchAdmin\api\controller\Withdrawal');
    // 文件上传
    $router->post('api/upload/image', '\catchAdmin\system\controller\Upload@image');
})->middleware(catchAdmin\api\middleware\AuthTokenMiddleware::class);
