<?php

namespace app\models;


class Addtask extends \app\Model

{
    
    public function run ( $params = [] )
    {
        
      if( !empty( $params ) ){

        $task = new \app\task\Task( $params['task_id'] );

        $result = $task->set( $params );

        if( $result['status'] == 'success' ){

          $_SESSION['message'] = 'Задача успешно создана';

          header('Location: /');
          
          exit;

        }

      }

      return [
        'page_title' => 'Создание новой задачи', 
        'task_id' => $params['task_id'], 
        'task_name' => $params['task_name'], 
        'task_body' => $params['task_body'], 
        'user_name' => $params['user_name'], 
        'user_email' => $params['user_email'], 
        'submit_text' => 'Создать задачу', 
        'error_message' => $result['error_message']  
      ];
        
    }
    
}
?>