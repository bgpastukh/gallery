<?php

class Route
{
    static function start()
    {
        // default controller and action
        $controller_name = 'Main';
        $action_name = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);
        array_shift($routes);

        // get controller
        if ( !empty($routes[1]) )
        {
            $controller_name = $routes[1];
        }

        // get action
        if ( !empty($routes[2]) )
        {
            $action_name = $routes[2];
        }

        // add prefixes
        $model_name = 'Model_'.$controller_name;
        $controller_name = 'Controller_'.$controller_name;
        $action_name = 'action_'.$action_name;

        // get model-class file

        $model_file = strtolower($model_name).'.php';
        $model_path = "../models/".$model_file;
        if(file_exists($model_path))
        {
            include "../models/".$model_file;
        }

        // get controller-class file
        $controller_file = strtolower($controller_name).'.php';
        $controller_path = "../controllers/".$controller_file;
        if(file_exists($controller_path))
        {
            include "../controllers/".$controller_file;
        }
        else
        {
            throw new Exception('Can`t find controller by address'. '../controllers/'.$controller_file);
        }

        // create controller
        $controller = new $controller_name;
        $action = $action_name;

        if(method_exists($controller, $action))
        {
            // call controller
            $controller->$action();
        }
        else
        {
            throw new Exception('Can`t call method'. $action_name);
        }
    }
}
