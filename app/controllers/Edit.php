<?php

namespace app\controllers;

use app\models;


class Edit extends \app\Controller
{
    
    function __construct ()
    {

      $this->model = new \app\models\Edittask;
      
    }

    public function index ()
    {
        
        $data = $this->model->run( $_GET );
        
        return $this->render('edittask', $data );
        
    }
    
}