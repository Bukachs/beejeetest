<?php

namespace app\controllers;

use app\models;


class Add extends \app\Controller
{
    function __construct ()
    {

      $this->model = new \app\models\Addtask;
      
    }

    public function index ()
    {
        
        $data = $this->model->run( $_GET );
        
        return $this->render( 'addtask', $data );
        
    }
    
}