<?php

class HomeController extends BaseController {
  
  function index() {
    $presenter = self::initializePresenter();
    $template = "views/home/index.php";
    $presenter["full_width"] = true;
    include("views/layouts/application.php");
  }
  
}

?>