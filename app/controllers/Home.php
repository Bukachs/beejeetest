<?php

namespace app\controllers;

use app\models;


class Home extends \app\Controller
{
    function __construct ()
    {

      $this->model = new \app\models\Home;
      
    }

    public function index ()
    {
        
        $data = $this->model->run();

        return $this->render( 'home', $data );
        
    }
    
}