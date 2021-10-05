<?php

namespace app;


class Controller 
{
    
    public $layout_file = 'views/layout.php';

    public function render_layout ( $body ) 
    {
      
      $page_title = $this->page_title;

      ob_start();

      require ROOTPATH.DIRECTORY_SEPARATOR.'app/'.$this->layout_file;

      return ob_get_clean();
                
    }
    
    public function render ( $view_name, array $params = [] )
    {
        
        $view_file = ROOTPATH.DIRECTORY_SEPARATOR.'app/views'.DIRECTORY_SEPARATOR.$view_name.'.php';

        extract( $params );

        $this->page_title = $page_title;

        ob_start();

        require $view_file;

        $body = ob_get_clean();

        ob_end_clean();

        if ( defined( NO_LAYOUT ) ){

          return $body;

        }

        return $this->render_layout( $body );
        
    }
    
}