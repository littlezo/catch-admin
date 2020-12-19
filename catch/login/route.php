<?php
$router->group(function () use ($router) {
    # 登入
    $router->get('test', '\catchAdmin\login\controller\Index@test');
    $router->post('login', '\catchAdmin\login\controller\Index@login');
    $router->post('logout', '\catchAdmin\login\controller\Index@logout');
    $router->post('refresh/token', '\catchAdmin\login\controller\Index@refreshToken');
});
