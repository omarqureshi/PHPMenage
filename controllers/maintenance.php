<?php

class MaintenanceController extends BaseController {

  function four_oh_four($params=array()) {
    $current_user = self::getCurrentUser();
    $presenter = self::initializePresenter();
    $template = "views/maintenance/404.php";
    $presenter["full_width"] = true;
    include("views/layouts/application.php");
  }

}

?>