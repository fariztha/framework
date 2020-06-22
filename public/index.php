<?php
$base  = dirname($_SERVER['PHP_SELF']);

// Update request when we have a subdirectory    
// if(ltrim($base, '/')){ 
//     $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen($base));
// }

use FastRoute\RouteCollector;

$container = require __DIR__ . '/../system/bootstrap.php';

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
//$dispatcher = FastRoute\cachedDispatcher(function (RouteCollector $r) {
    
    $r->addRoute('GET', '/', ['App\Controllers\TestController','home']);
    $r->addRoute('GET', '/article/{id}', ['App\Controllers\TestController', 'article']);
    $r->addRoute('GET', '/coba', ['App\Controllers\TestController','index']);
    $r->addRoute('GET', '/cookie', ['App\Controllers\TestController','cookie']);
    $r->addRoute('POST', '/post', ['App\Controllers\TestController','post']);
    $r->addRoute('GET', '/konversi', ['App\Controllers\TestController','konversi']);
    $r->addRoute('GET', '/token', ['App\Controllers\TestController','create_token']);
    $r->addRoute('GET', '/validate', ['App\Controllers\TestController','validate_token']);
    $r->addRoute('GET', '/password', ['App\Controllers\TestController','password']);
    $r->addRoute('POST', '/login', ['App\Controllers\TestController','login']);
    $r->addRoute('GET', '/smtp', ['App\Controllers\TestController','Send_email']);

    // Clien api
    $r->addGroup('/api/client', function (RouteCollector $r) {
        $r->addRoute('POST', '/auth', ['App\Controllers\AuthController','login']);
        $r->addRoute('GET', '/coba', ['App\Controllers\CobaApiController','coba']);
    });
    
    
},[
    //'cacheFile' => __DIR__ . '/../storage/cache/route/route.cache', /* required */
    //'cacheDisabled' => IS_DEBUG_ENABLED,     /* optional, enabled by default */
]);

$route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        //call controller 404 notfound
        $container->call(['App\Controllers\PageController','halaman404']);
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        //call controller 405 method not allowed
        $container->call(['App\Controllers\PageController','halaman405']);
        break;

    case FastRoute\Dispatcher::FOUND:
        $controller = $route[1];
        $parameters = $route[2];
        // We could do $container->get($controller) but $container->call()
        // does that automatically
        $container->call($controller, $parameters);
        break;
}
