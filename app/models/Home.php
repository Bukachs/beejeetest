<?php

namespace app\models;


class Home extends \app\Model

{
    
    const COUNT_ON_PAGE = 3;

    const DEFAUL_SORT_FIELD = 'user_name';

    public function run ( $params = [] )
    { 
        
      $_SESSION['order'] = $_SESSION['order'] ?: self::DEFAUL_SORT_FIELD;
      
      if( $_GET['order'] ){

        $_SESSION['order'] = $_GET['order'];

        header('Location: /');

        exit();

      }

      $db = \app\App::$db;

      $count_on_page = self::COUNT_ON_PAGE;

      $tasks_list = '';

      $_GET['page'] = is_numeric( $_GET['page'] ) ? $_GET['page'] : 1;

      $tasks = $db->execute(
        'tasks', 
        null,
        [
          'limit' => [ $count_on_page * ( is_numeric( $_GET['page'] ) ? $_GET['page'] -1 : 0 ), $count_on_page],
          'order' => [ $_SESSION['order'] => 'ask' ]
        ]
      );

      $count_selected_tasks =  count( $tasks );

      if( $count_selected_tasks ){

        $count_tasks = count( $db->execute('tasks') );

        foreach( $tasks as $task ){

          $tasks_list .= $task->veiew_row();

        }

        $Pages = array();

        $count_pages = ceil( $count_tasks/$count_on_page );

        if( $count_pages > 1 ){

          for( $p = 1; $p < $count_pages + 1; ++$p ){

            $p_link = ( is_numeric( $_GET['page'] ) && $_GET['page'] == $p ) ? $p : '<a href="?page='.$p.'">'.$p.'</a>';

            $Pages[] = '<span style="padding-right:.25rem;padding-left:.25rem">'.$p_link.'</span>';

          }

          $pagination = '<div>Стр.: '.implode('', $Pages).'</div>';

        }

        if( $count_tasks > 1 ){

          $order_options = '<form method="GET" action="">
            <lable>Сортировка: </label>
            <select name="order">
              '.$task->get_order_options().'
            </select>
            <input type="submit" value="Упорядочить">
          </form>';

        }

      }else{

        $tasks_list = 'Задач не создано';

      }

      if( $_SESSION['message'] ){

        $message = $_SESSION['message'];
        
        unset( $_SESSION['message'] );

      }

      return [ 'page_title' => 'Список задач', 'order_options' => $order_options, 'tasks_list' => $tasks_list, 'pagination' => $pagination, 'message' => $message ];
        
    }
    
}
?>