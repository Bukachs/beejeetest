<?php

namespace app\controllers;

use app\models;


class Signin extends \app\Controller
{
    function __construct ()
    {

      $this->model = new \app\models\Signin;
      
    }

    public function index ()
    {
        
        $data = $this->model->run( $_GET );

        return $this->render( 'signin', $data );
        
    }
    
}