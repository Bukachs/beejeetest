<?php

namespace app\controllers;

use app\models;


class Signout extends \app\Controller
{
    
    public function index ()
    { 

      unset( $_SESSION['is_admin'] );

      $_SESSION['message'] = 'Вы вышли из системы.';
        
      header('Location: /');
        
    }
    
}