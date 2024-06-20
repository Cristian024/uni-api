<?php

namespace App\Services;
use App\Controllers\General\ResponseController;

class Router{
    public static $routes = [];

    public static function get($uri, $callback)
    {
        Router::addRoute('GET', $uri, $callback);
    }

    public static function post($uri, $callback)
    {
        Router::addRoute('POST', $uri, $callback);
    }

    public static function put($uri, $callback)
    {
        Router::addRoute('PUT', $uri, $callback);
    }

    public static function delete($uri, $callback)
    {
        Router::addRoute('DELETE', $uri, $callback);
    }

    private static function addRoute($method, $uri, $callback)
    {
        Router::$routes[] = [
            'method' => $method,
            'uri' => $uri,
            'callback' => $callback
        ];
    }

    public static function dispatch($method, $uri)
    {
        foreach (Router::$routes as $route) {
            if ($route['method'] === $method && $route['uri'] === $uri) {
                call_user_func_array($route['callback'], []);
            }
        }
        ResponseController::sentNotFoundResponse('Route `'.$uri.'` with method `'.$method.'` is not defined');
    }

    private static function convertToRegex($uri)
    {
        return '/^' . str_replace(['/', '{', '}'], ['\/', '(?P<', '>[^\/]+)'], $uri) . '$/';
    }
}