<?php

class HomeController extends BaseController {
  
  function _index($params=array()) {
    $presenter = self::initializePresenter();
    $template = "views/home/index.php";
    $presenter["full_width"] = true;
    include("views/layouts/application.php");
  }
  
}

?>