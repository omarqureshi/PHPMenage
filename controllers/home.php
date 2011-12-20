<?php

class HomeController extends BaseController {

  function _index($params=array()) {
    $current_user = self::getCurrentUser();
    $presenter = self::initializePresenter();
    $template = "views/home/index.php";
    $presenter["full_width"] = true;
    include("views/layouts/application.php");
  }

}

?>