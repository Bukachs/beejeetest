<?php

namespace app\task;

class Task{

  const INDEX_KEY = 'task_id';

  const ORDER_OPTIONS = [
    'user_name' => 'Имя пользователя',
    'user_email' => 'Эл. почта',
    'task_body' => 'Текст задачи'
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

      return '<li style="margin-bottom:2rem">
                  <div>#'.$this->task_id.' '.( $this->task_closed ? ' Выполнена! ' : '' ).' '.( $this->task_date_edited ? 'Отредактирована администратором '.strftime('%Y-%m-%d %H:%M:%S', strtotime( $this->task_date_edited ) ) : '' ).' '.$this->user_name.' '.$this->user_email.' '.$this->task_name.'</div>
                  <div>'.$task_body.'</div>
                  '.( ( $_SESSION['is_admin'] ) ? '<div><a href="/edit/?task_id='.$this->task_id.'">Править</a> <a href="/delete/?task_id='.$this->task_id.'">Удалить</a></div>' : '' ).'
            </li>';
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