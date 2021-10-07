<?php

namespace app\models;


class Home extends \app\Model

{
    
    const COUNT_ON_PAGE = 3;

    const DEFAUL_SORT_FIELD = 'user_name_asc';

    public function run ( $params = [] )
    { 
        
      $_SESSION['order'] = $_SESSION['order'] ?: self::DEFAUL_SORT_FIELD;
      
      if( $_GET['order'] ){

        $_SESSION['order'] = $_GET['order'];

        header('Location: '.$_SERVER['HTTP_REFERER']);

        exit();

      }

      $db = \app\App::$db;

      $count_on_page = self::COUNT_ON_PAGE;

      $tasks_list = '';

      $_GET['page'] = is_numeric( $_GET['page'] ) ? $_GET['page'] : 1;

      $Order = explode('_', $_SESSION['order'] );

      $order_direction = array_slice( $Order, -1 )[0];

      $order_direction = in_array( $order_direction, ['asc', 'desc'] ) ? $order_direction : 'asc';

      $tasks = $db->execute(
        'tasks', 
        null,
        [
          'limit' => [ $count_on_page * ( is_numeric( $_GET['page'] ) ? $_GET['page'] -1 : 0 ), $count_on_page],
          'order' => [ implode('_', array_slice( $Order, 0, -1 ) ) => $order_direction ]
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

            $p_link = ( is_numeric( $_GET['page'] ) && $_GET['page'] == $p ) ? '<span class="nav-link px-2 text-muted ">'.$p.'</span>' : '<a href="?page='.$p.'" class="nav-link px-2">'.$p.'</a>';

            $Pages[] = '<li class="nav-item">'.$p_link.'</li>';

          }

          $pagination = '<ul class="nav justify-content-center border-bottom pb-3 mb-3 mt-4"><li class="nav-item"><span class="nav-link px-2 text-muted">Стр: </span></li>'.implode('', $Pages).'</ul>';

        }

        if( $count_tasks > 1 ){

          $order_options = '
          <div class="row">
            <div class="col-sm-6">
              <form method="GET" action="">
              <div class="input-group my-5">
                  <select class="form-select" id="sort" name="order">
                    '.$task->get_order_options().'
                  </select>
                  <input class="btn btn-secondary" type="submit" value="Упорядочить">
                </div>
              </form>
            </div>
          </div>
          ';

        }

      }else{

        $message = '<div class="py-5 text-center">Задач не создано</div>';

      }

      if( $_SESSION['message'] ){

        $message = $_SESSION['message'];
        
        unset( $_SESSION['message'] );

      }

      return [ 'page_title' => 'Список задач', 'order_options' => $order_options, 'tasks_list' => $tasks_list, 'pagination' => $pagination, 'message' => $message ];
        
    }
    
}
?>