<?php

namespace app\models;


class Signin extends \app\Model

{
    

    private $Users = [

      'admin' => [

        'pass' => '123'
        
      ]

    ];


    public function run ( $params = [] )
    {
        
        if( !empty( $params ) ){

          if( $this->Users[ $params['user_login'] ] && $params['user_pass'] === $this->Users[ $params['user_login'] ]['pass'] ) $_SESSION['is_admin'] = TRUE;

          if( $_SESSION['is_admin'] ){

            $_SESSION['message'] = 'Вы вошли как администратор';

            header('Location: /');
            exit;

          }else{

            $error_message = 'Логин или пароль не совпали';

          }

        }

        return [
          'page_title' => 'Вход на сайт', 
          'user_login' => $params['user_login'], 
          'user_pass' => '',//$params['user_pass'], 
          'submit_text' => 'Войти', 
          'error_message' => $error_message 
        ];
        
    }
    
}
