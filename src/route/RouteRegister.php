<?php


namespace Route;


class RouteRegister
{

    private $routes = [];

    public function group(string $prefix, array $middleware, \Closure $closure)
    {
        echo 1;
    }
}