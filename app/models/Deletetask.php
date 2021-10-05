<?php

namespace app\models;


class Deletetask extends \app\Model

{
    
    public function run ( $params = [] )
    {   

      $task = new \app\task\Task( $params['task_id'] );

      if( !empty( $params['confirm'] ) ){

        $result = $task->delete();

        if( $result['status'] == 'success' ){

          $_SESSION['message'] = 'Задача #'.$task->task_id.' удалена';

          header('Location: /');

          exit;

        }

      }

      return [
        'page_title' => 'Удалить задачу', 
        'task_id' => $task->task_id, 
        'task_name' => $task->task_name, 
        'submit_text' => 'Удалить', 
        'submit_decline_text' => 'Отмена', 
        'error_message' => $result['error_message']  
      ];
      
    }
    
}
?>