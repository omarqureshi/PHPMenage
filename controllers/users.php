<?php

class UsersController extends BaseController {
  
  function _new($params=array()) {
    $presenter = self::initializePresenter(array("page_name" => "Register"));
    $template = "views/users/new.php";
    $right_rail = "views/users/_registration_info.php";
    $user = new User();
    include("views/layouts/application.php");
  }
  
  function _create($params=array()){

  }
  
}

?>