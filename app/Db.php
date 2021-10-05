<?php

namespace app;


class Db 

{

    const DB_PATH = 'app/data/';

    const DATA_SEPARATOR = ',';

    private $settings = [];
    
    public function __construct()
    {
       
      $this->settings = $this->getDBSettings();

    }
    
    protected function getDBSettings()
    {
        
      $this->settings = include ROOTPATH.DIRECTORY_SEPARATOR.'app/config'.DIRECTORY_SEPARATOR.'Db.php';

      return $this->settings;
     
    }
    
    public function execute( string $file, array $condition = null, array $optons = NULL ) : array
    {
      
      $Data = array();

      if ( ($handle = fopen( ROOTPATH.DIRECTORY_SEPARATOR.self::DB_PATH."$file.csv", "r" ) ) !== FALSE ) {

          $index_key = $this->settings[ 'map' ][ $file ][ 0 ];

          while ( ( $row = fgetcsv( $handle, 1000, self::DATA_SEPARATOR) ) !== FALSE ) {

            $count_fields = count( $row );

            $Row = array();
            
            for ( $f = 0; $f < $count_fields; $f++ ) {

              $Row[ $this->settings[ 'map' ][ $file ][ $f ] ] = $row[ $f ];

            }

            $obj = new \app\task\Task( $Row );//здесь можно определять тип объекта БД. Опущено в целях экономии времени.

            if( !$obj->task_id ) continue;

            if( $condition[ $index_key ] && $condition[ $index_key ] == $obj->{ $index_key } ) return [ $obj->{ $index_key } => $obj ];

            $Data[ $obj->{ $index_key } ] = $obj;

          }

          fclose( $handle );

          $Sort = [];

          foreach( $optons['order'] as $order_field => $order_direction ){
         
            foreach( $Data as $obj_key => $obj ){

              $Sort[ $obj->{ $order_field } ][] = $obj_key;

            }

            ( $order_direction == 'ask' ) ? ksort( $Sort ) : krsort( $Sort ) ;

            $_Data = [];

            foreach( $Sort as $fv => $objects_keys ){

              foreach( $objects_keys as $obj_key ){

                $_Data[ $obj_key ] = $Data[ $obj_key ];

              }

            }

            $Data = $_Data;

          }

          $row_start = $optons['limit'][0] ?: 0;

          $limit = $optons['limit'][1] ?: 1000;

          $Data = array_slice( $Data, $row_start, $limit );


        }

        return $Data;
        
    }



    public function create( string $file, array $data = null, $index_key ) : array
    {
      
      $result = array('status' => 'error');

      if ( ( $handle = fopen( ROOTPATH.DIRECTORY_SEPARATOR.self::DB_PATH."$file.csv", "r+") ) !== FALSE ) {

          $data[ $index_key ] = 0;

          while (($row = fgetcsv($handle, 1000, self::DATA_SEPARATOR)) !== FALSE) {

            $index_id = $row[ array_search( $index_key, $this->settings['map'][ $file ] ) ];

            $data[ $index_key ] = $index_id > $data[ $index_key ] ? $index_id : $data[ $index_key ];
  
          }

          ++$data[ $index_key ];


          foreach( $this->settings['map'][ $file ] as $field ){

            $res_validate = $this->validate( $field, $data[ $field ] );

            if( $res_validate['status'] == 'success' ){

              $Data[] = $res_validate['value'];

            }else{

              return $res_validate;

            }

          }

          ksort( $Data );

          $res = fputcsv( $handle, $Data );

          if( is_numeric( $res ) ){

            $result['status'] = 'success';

          }else{

            $result['error_message'] = 'Не могу записать данные в файл.';

          }
          
          fclose( $handle );

      }else{

        $result['error_message'] = 'Файл БД не существует.';

      }

      return $result;
        
    }

    public function update( string $file, array $condition, $data ) : array
    {
      
      $result = array( 'status' => 'error' );

      $Data = array();

      if ( ( $handle = fopen( ROOTPATH.DIRECTORY_SEPARATOR.self::DB_PATH."$file.csv", "r") ) !== FALSE ) {

          $new_data = array();

          foreach( $this->settings[ 'map' ][ $file ] as $field ){

            $res_validate = $this->validate( $field, $data[ $field ] );

            if( $res_validate['status'] == 'success' ){

              $new_data[] = $res_validate['value'];

            }else{

              return $res_validate;

            }

          }

          while ( ( $row = fgetcsv( $handle, 1000, self::DATA_SEPARATOR ) ) !== FALSE) {

            $editble_row = array();

            $editible = false;

            foreach( $condition as $field_name => $field_value ){

              $field_index = array_search( $field_name, $this->settings[ 'map' ][ $file ] );

              if( $row[ $field_index ] == $field_value ){

                $editible = true;

              }else{

                $editible = false;

              }

            }
          
            if( $editible ){

              $editble_row = $new_data;

            }

            $Data[] = empty( $editble_row ) ? $row : $editble_row;

          }

          fclose( $handle );

          ksort( $Data );

          if ( ( $handle = fopen( ROOTPATH.DIRECTORY_SEPARATOR.self::DB_PATH."$file.csv", "w" ) ) !== FALSE ) {

            foreach ( $Data as $row ) {

              $res = fputcsv( $handle, $row );

            }

            fclose( $handle );

          }   
            
          if( is_numeric( $res ) ){

            $result['status'] = 'success';

          }else{

            $result['error_message'] = 'Не могу записать данные в файл.';

          }
          
          fclose( $handle );

      }else{

        $result['error_message'] = 'Файл БД не существует.';

      }

      return $result;
        
    }

    public function delete( string $file, array $condition ) : array
    {
      
      $result = array('status' => 'error');

      if ( ( $handle = fopen( ROOTPATH.DIRECTORY_SEPARATOR.self::DB_PATH."$file.csv", "r" ) ) !== FALSE) {

        while ( ( $row = fgetcsv( $handle, 1000, self::DATA_SEPARATOR) ) !== FALSE ) {

          $row_data = array();

          $deleted = false;

          foreach( $condition as $field_name => $field_value ){

            $field_index = array_search( $field_name, $this->settings[ 'map' ][ $file ] );

            if( $row[ $field_index ] == $field_value ){

              $deleted = true;

            }else{

              $deleted = false;

            }

          }
   
          if( !$deleted ){

            $Data[] = $row;

          }
          
        }

        fclose( $handle );

        ksort( $Data );

        if ( ( $handle = fopen( ROOTPATH.DIRECTORY_SEPARATOR.self::DB_PATH."$file.csv", "w") ) !== FALSE ) {

          foreach ($Data as $row) {

            $res = fputcsv($handle, $row);

          }

          fclose( $handle );

        }   
          
        if( is_numeric( $res ) || empty( $Data ) ){

          $result['status'] = 'success';

        }else{

          $result['error_message'] = 'Не могу записать в файл.';

        }
        
        fclose( $handle );

      }else{

        $result['error_message'] = 'Файл БД не существует.';

      }

      return $result;
        
    }

    function validate( $field, $value ) : array{

      $result = array('status' => 'error');

      $value = trim( $value );

      $value = strip_tags( $value );

      switch( $field ){

        case 'user_email':

            if( !$value || !preg_match( '/([a-zA-Z0-9\-_\.]){2,30}@([a-zA-Z0-9\-_\.]){2,10}\.([a-zA-Z0-9\-_\.]){2,10}/ui', $value ) ){

              $result['error_message'] = 'Поле '.$field.' не является адресом эл. почты';

            }else{

              $result['status'] = 'success';

            }

          break;
        case 'task_closed':

            if( $value && $value !== 'on' ){

              $result['error_message'] = 'Поле '.$field.' содержит некорректный формат данных';

            }else{

              $result['status'] = 'success';

            }

          break;
        case 'task_date_edited':

            $result['status'] = 'success';
            
          break;
        default:

            if( !( $value ) ){

              $result['error_message'] = 'Поле '.$field.' должно содержать данные';

            }else{

              $result['status'] = 'success';

            }

            
          break;

      }

      $result['value'] = $value;

      return $result;

    }  

}