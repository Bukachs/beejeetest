<?php

namespace app;

class App

{
        
    public static $router;
    
    public static $db;
    
    public static $kernel;
    
    public static function init ()
    {
      
      spl_autoload_register(['static','load_class']);

      static::bootstrap();

      set_exception_handler(['app\app','handle_exception']);
    }
    
    public static function bootstrap ()
    {   

      static::$router = new \app\Router();

      static::$kernel = new \app\Kernel();

      static::$db = new \app\Db();

    }
    
    public static function load_class ( $class_name )
    {
       
      $class_name = str_replace('\\', DIRECTORY_SEPARATOR, $class_name );

      require_once ROOTPATH.DIRECTORY_SEPARATOR.$class_name.'.php';
        
    }
    
    public function handle_exception ( \Throwable $e )
    {
         
      if( $e instanceof \app\exceptions\InvalidRouteException ) {

        echo static::$kernel->launchAction( 'Error', 'error404', [ $e ] );

      }else{

        echo static::$kernel->launchAction( 'Error', 'error500', [ $e ] );  

      }
        
    }
    
}