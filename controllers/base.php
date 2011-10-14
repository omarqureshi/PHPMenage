<?php

class BaseController {
  
  function initializePresenter () {
    $presenter = array();
    $presenter["application_name"] = "Content M&eacute;nage";
    $presenter["full_width"] = false;
    return $presenter;
  }
  
}

?>