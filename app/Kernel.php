<?php

namespace app;

use app\exceptions;


class Kernel 

{
    
    public $default_controller_name = 'Home';
    
    public $defaultaction_name = "index";
    
    public function launch ()
    {
    
      list( $controller_name, $action_name, $params ) = App::$router->resolve();

      echo $this->launchAction( $controller_name, $action_name, $params );
            
    }
    

    public function launchAction ( $controller_name, $action_name, $params )
    {
          
      $controller_name = empty($controller_name) ? $this->default_controller_name : ucfirst( $controller_name );

      if( !file_exists( ROOTPATH.DIRECTORY_SEPARATOR.'app/controllers'.DIRECTORY_SEPARATOR.$controller_name.'.php' ) ){

        throw new \app\exceptions\InvalidRouteException("Controller name '$controller_name' not exists");

      }

      require_once ROOTPATH.DIRECTORY_SEPARATOR.'app/controllers'.DIRECTORY_SEPARATOR.$controller_name.'.php';

      if( !class_exists("\\app\\controllers\\".ucfirst( $controller_name ) ) ){

        throw new \app\exceptions\InvalidRouteException('Class '."\\app\\controllers\\".ucfirst($controller_name).' not exists ');

      }

      $controller_name = "\\app\\controllers\\".ucfirst( $controller_name );

      $controller = new $controller_name;

      $action_name = empty($action_name) ? $this->defaultaction_name : $action_name;

      if ( !method_exists( $controller, $action_name ) ){

        throw new \app\exceptions\InvalidRouteException( 'Method '.$action_name.' not exists in controller'.$controller_name );

      }

      return $controller->$action_name($params);
        
    }

}