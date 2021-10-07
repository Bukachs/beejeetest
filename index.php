<?php

namespace app;


error_reporting(E_ALL);

ini_set('display_errors', 'On');

ini_set('error_reporting', 81);

ini_set('display_errors', 1);

clear_injections();

session_start();

define('ROOTPATH', __DIR__);

define( 'NO_LAYOUT', FALSE );

require __DIR__.'/app/App.php';
     
App::init();

App::$kernel->launch();


function clear_injections( &$_Data = NULL ){

  $_Data = ( is_array( $_Data ) || is_object( $_Data ) ) ? $_Data : array( &$_GET, &$_POST );

  foreach( $_Data as $k => &$data ){

    if( !is_numeric( $k ) && preg_match('/delete |create |select |drop |index /ui', urldecode( $k ) ) ){

      unset( $_Data[ $k ] );

      continue;
      
    }

    if( $k == 'data' && strlen( $data ) > 128 ) continue;

    if( !empty( $data ) ){

      if( is_array( $data ) || is_object( $data ) ){

        clear_injections( $data );

      }else{

        if( isset( $data ) ) $data = preg_replace(['/\"/ui', "/\'/ui", '/(delete |create |select |drop |index )/ui'], ['', '', ''], urldecode( $data ) );

      }

    }

  }

}

?>