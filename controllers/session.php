<?php

class SessionController extends BaseController {
  
  function new() {
    $presenter = self::initializePresenter();
    $template = "views/session/new.php";
    include("views/layouts/application.php");
  }
  
}

?>