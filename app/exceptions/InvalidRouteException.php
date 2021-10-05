<?php

namespace app\exceptions;


class InvalidRouteException extends \Exception {

  public function getName ()
  {
        return 'Invalid Route';
  }

}
