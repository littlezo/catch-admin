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
    // tradeHall路由
    $router->rule('trade/hall/layout', '\catchAdmin\trade\controller\TradeHall@layout');
    $router->resource('trade/hall', '\catchAdmin\trade\controller\TradeHall');
    // tradeRecharge路由
    $router->rule('trade/recharge/layout', '\catchAdmin\trade\controller\TradeRecharge@layout');
    $router->resource('trade/recharge', '\catchAdmin\trade\controller\TradeRecharge');
    // tradeWithdrawal路由
    $router->rule('trade/withdrawal/layout', '\catchAdmin\trade\controller\TradeWithdrawal@layout');
    $router->resource('trade/withdrawal', '\catchAdmin\trade\controller\TradeWithdrawal');
    // tradeConfig路由
    // $router->rule('trade/config/layout', '\catchAdmin\trade\controller\tradeConfig@layout');
    // $router->get('trade/config/pay', '\catchAdmin\trade\controller\TradeConfig@payRead');
    // $router->post('trade/config/pay', '\catchAdmin\trade\controller\TradeConfig@paySave');
    $router->get('trade/config/parent', '\catchAdmin\trade\controller\TradeConfig@parent');
    $router->get('trade/config/:parent', '\catchAdmin\trade\controller\TradeConfig@read');
    $router->post('trade/config/:parent', '\catchAdmin\trade\controller\TradeConfig@save');
    // $router->resource('trade/config', '\catchAdmin\trade\controller\TradeConfig');
})->middleware('auth');
