<?php

class MaintenanceController extends BaseController {
  
  function four_oh_four($params=array()) {
    $presenter = self::initializePresenter();
    $template = "views/maintenance/404.php";
    $presenter["full_width"] = true;
    include("views/layouts/application.php");
  }
  
}

?>