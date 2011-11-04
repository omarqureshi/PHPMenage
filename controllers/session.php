<?php

class SessionController extends BaseController {
  
  function _create($params=array()) {
    $presenter = self::initializePresenter();
    self::return_to($params);
  }
  
}

?>