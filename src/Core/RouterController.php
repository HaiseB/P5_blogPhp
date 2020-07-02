<?php

namespace App\Core;

use AltoRouter;

class RouterController extends AltoRouter{

    public function callRoute($target, $params){
        if (stripos($target, ':') !== false) {
            list($controller, $method) = explode(':', $target, 2);

            $controllerPath = "App\Controllers\\" . $controller;
            $object = new $controllerPath;

            if ($params) {
                call_user_func_array(array($object, $method), array($params['id']));
            } else {
                call_user_func(array($object, $method));
            }
        } else {
            header('Location: /');
            die;
        }

    }

}