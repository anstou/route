<?php


include "../../src/route/ReadRoutes.php";
$a = new \Route\ReadRoutes('D:\比邻智学\admin\application\modules','User');


exit;
$routeJson = json_decode(file_get_contents('routes.json'), true);
var_dump($routeJson);
$routes = [];


function readRoute($routeJson, &$routes, $prefix = '')
{

    foreach ($routeJson as $key => $route) {
        if ($key === 'methods') break;

        $url = $prefix . '/' . trim($key, '/');
        if (empty($route['methods'])) {
            $routes[] = 'GET:' . $url;
        } else {
            $routes[] = implode(',', $route['methods']) . ':' . $url;
//            foreach ($route['methods'] as $method) {
//                $routes[] = $method . ':' . $url;
//            }
        }


        unset($route['methods']);
        if (count($route) > 0)
            readRoute($route, $routes, $url);
    }
}

readRoute($routeJson, $routes);

var_dump($routes);