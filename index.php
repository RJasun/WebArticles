<?php
declare(strict_types=1);
require_once 'vendor/autoload.php';

$loader = new Twig\Loader\FilesystemLoader(__DIR__ . '/app/Views');
$twig = new Twig\Environment($loader);

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $router) {
    $router->addRoute('GET', '/UN/articles', ['App\Controllers\ArticleController', 'index']);
    $router->addRoute('GET', '/UN/articles/{id}', ['App\Controllers\ArticleController', 'show']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $vars = $routeInfo[2];
        [$controller, $method] = $routeInfo[1];
        $response = (new $controller)->{$method}($vars);
        echo $twig->render($response->getViewName(), $response->getData());
        break;
}
