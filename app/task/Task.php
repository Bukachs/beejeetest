<?php

namespace app\task;

class Task{

  const INDEX_KEY = 'task_id';

  const ORDER_OPTIONS = [
    'user_name_asc' => 'Имя пользователя ↓',
    'user_name_desc' => 'Имя пользователя ↑',
    'user_email_asc' => 'Эл. почта ↓',
    'user_email_desc' => 'Эл. почта ↑',
    'task_body_asc' => 'Текст задачи ↓',
    'task_body_desc' => 'Текст задачи ↑'
  ];

  function __construct( $_task= null ){

    $this->db = \app\App::$db;

    if( $_task ){

      $data = is_numeric( $_task ) ? $this->db->execute('tasks', [ self::INDEX_KEY => $_task ] )[ $_task ] : $_task;

      foreach( $data as $k => $v ){

        $this->$k = $v;

      }

    }



  }

  function set( $data = [] ) : array {

    $data['task_body'] = base64_encode( $data['task_body'] );

    $result = ['status' => 'error'];

    if( $this->{ self::INDEX_KEY } ){

      if( !$_SESSION['is_admin'] ){

        header('Location: /signin');

        exit();

      }

      if( $data['task_body'] != $this->task_body ){

        $data['task_date_edited'] = strftime('%c');

      }

      $result = $this->db->update('tasks', [ self::INDEX_KEY => $data[ self::INDEX_KEY ] ], $data );

    }else{

      $result =  $this->db->create('tasks', $data, self::INDEX_KEY );
      
    }

    return $result;
 
  }

  function delete(){

    if( !$_SESSION['is_admin'] ){

      header('Location: /signin');

      exit();
    }

    $result = ['status' => 'error'];

    if( $this->{ self::INDEX_KEY } ){

      $result = $this->db->delete('tasks', [ self::INDEX_KEY => $this->{ self::INDEX_KEY } ] );

    }

    return $result;

  }

  function veiew_row(){

    if( $this->task_id )

      if( isset( $this->task_body ) ) $task_body = '<p>'.implode( '</p><p>', explode("\r\n", base64_decode( $this->task_body ) ) ).'</p>';

      return '<div class="col">
        <div class="card shadow-sm">
          <div class="card-body">
            <h2 class="card-title">#'.$this->task_id.' '.$this->task_name.'</h2>
            <p class="card-text text-muted">'.$this->user_name.' > '.$this->user_email.'</p>
            <p class="card-text">'.$task_body.'</p>
            <div class="d-flex justify-content-between align-items-center">
              '.( $_SESSION['is_admin'] ? '
              <div class="btn-group">
                <a href="/edit/?task_id='.$this->task_id.'" type="button" class="btn btn-sm btn-outline-secondary">Править</a>
                <a href="/delete/?task_id='.$this->task_id.'" type="button" class="btn btn-sm btn-outline-secondary">Удалить</a>
              </div>' : '' ).'
              <div>
              '.( $this->task_closed ? '<small class="text-muted">Выполнена!</small>' : '' ).'
              </div>
            </div>
            '.( $this->task_date_edited ? '<div class="mt-2"><small class="text-muted" title="Дата редактирования: '.strftime('%Y-%m-%d %H:%M:%S', strtotime( $this->task_date_edited ) ).'">Отредактирована администратором</small></div>' : '' ).'
          </div>
        </div>
      </div>';

  }

  function get_order_options() : string {

    $order_options = '';

    foreach( self::ORDER_OPTIONS as $option_field => $option_name ){
      $s = '';
      if( $_SESSION['order'] == $option_field ) $s = ' selected="selected"';
      $order_options .= '<option value="'.$option_field.'"'.$s.'>'.$option_name;
    }


    return $order_options;

  }


}


?>