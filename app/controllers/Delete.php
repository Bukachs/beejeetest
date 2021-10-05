<?php

namespace app\controllers;

use app\models;


class Delete extends \app\Controller
{
    function __construct (){

      $this->model = new \app\models\Deletetask;
      
    }

    public function index ()
    {
        
        $data = $this->model->run( $_GET );
        
        return $this->render( 'deletetask', $data );
        
    }
    
}