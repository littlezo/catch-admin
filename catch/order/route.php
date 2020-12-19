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
    // tradeGoods路由
    $router->rule('trade/goods/layout', '\catchAdmin\order\controller\TradeGoods@layout');
    $router->resource('trade/goods', '\catchAdmin\order\controller\TradeGoods');
    // tradeOrder路由
    $router->rule('trade/order/layout', '\catchAdmin\order\controller\TradeOrder@layout');
    $router->resource('trade/order', '\catchAdmin\order\controller\TradeOrder');
})->middleware('auth');
