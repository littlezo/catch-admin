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
    // member路由
    $router->get('/member/members/layout', '\catchAdmin\member\controller\Member@layout');
    $router->resource('/member/members', '\catchAdmin\member\controller\Member');
    // member路由
    $router->get('/member/inside/layout', '\catchAdmin\member\controller\Inside@layout');
    $router->resource('/member/inside', '\catchAdmin\member\controller\Inside');
    // level路由
    $router->get('/member/level/layout', '\catchAdmin\member\controller\Level@layout');
    $router->resource('/member/level', '\catchAdmin\member\controller\Level');
    // tree路由
    $router->get('/member/tree/layout', '\catchAdmin\member\controller\Tree@layout');
    $router->resource('/member/tree', '\catchAdmin\member\controller\Tree');
    // message路由
    $router->rule('/member/message/layout', '\catchAdmin\member\controller\Message@layout');
    $router->resource('/member/message', '\catchAdmin\member\controller\Message');
})->middleware('auth');
