<?php


function route_contains($name, $operator = '=')
{
    $route = is_null(request()->route()) ? '' : request()->route()->getName();
    if ($operator == '=') {
        return $route == $name;
    }
    $pos = strpos($route, $name);
    return $pos !== false;
}