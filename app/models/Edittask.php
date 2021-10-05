<?php

namespace app\models;


class Edittask extends \app\Model
{
    
    public function run ( $params = [] )
    {   

      $task = new \app\task\Task( $params['task_id'] );

      if( !empty( $params['submit'] ) ){

        $result = $task->set( $params );

        if( $result['status'] == 'success' ){

          $_SESSION['message'] = 'Задача #'.$task->task_id.' исправлена';

          header('Location: /');
          exit;

        }

      }

      return [
        'page_title' => 'Редактировать задачу', 
        'task_id' => $task->task_id, 
        'task_name' => $task->task_name, 
        'task_body' => base64_decode( $task->task_body ),
        'task_closed' => $task->task_closed,
        'user_name' => $task->user_name, 
        'user_email' => $task->user_email, 
        'submit_text' => 'Исправить', 
        'error_message' => $result['error_message']  
      ];
        
    }
    
}
?>