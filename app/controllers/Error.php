<?php

namespace app\controllers;


class Error extends \app\Controller
{
    
    public function error404 ( $e )
    {
        
        return $this->render('error404', [ 'errorMessage' => $e[0]->getMessage() ] );
        
    }

    public function error500 ( $e )
    {
        
        return $this->render( 'error500', [ 'errorMessage' => print_r( $e[0], true ) ] );
        
    }
    
}