<?php

require_once("helpers.php");

/**
 * All requests from PHPUICreator must call this script
 *
 * @author Xavier Piquer
 */
class bootstrap
{
    public function __construct()
    {
        if(!isset($_REQUEST['controller']) || ! isset($_REQUEST['method']))
        {
            \helpers::sayKo("Controller and method must be passed by param.");
            die();
        }
        
        if(isset($_REQUEST['XDEBUG_SESSION_START']))
        {
            $s_controller = filter_input(INPUT_GET, 'controller', FILTER_SANITIZE_STRING);
            $s_action = filter_input(INPUT_GET, 'method', FILTER_SANITIZE_STRING);
        }
        else
        {
            $s_controller = filter_input(INPUT_POST, 'controller', FILTER_SANITIZE_STRING);
            $s_action = filter_input(INPUT_POST, 'method', FILTER_SANITIZE_STRING);
        }
                
        spl_autoload_register(function ($s_controller)
        {
            $s_controller = strtr($s_controller, array("\\" => "/"));
            $file = "../".$s_controller.".php";

            if(is_readable($file))
            {
                require_once $file;
            }
            else
            {
                \helpers::sayKo("Controller [".$_REQUEST['controller']."] does'nt exist.");
                die();
            }
        });
        
        $controllerInstance = new $s_controller;
        $params = $_REQUEST;
        
        if ((int)method_exists($controllerInstance, $s_action))
        {    
            call_user_func_array(array($controllerInstance, $s_action), $params);
        }
        else
        {
            \helpers::sayKo("Method [".$s_action."] in controller [".$controller."] does'nt exist.");
            die();
        }
    }
}

new bootstrap();