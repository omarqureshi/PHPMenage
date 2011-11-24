<?php

class UsersController extends BaseController {
  
  function _new($params=array()) {
    $current_user = self::getCurrentUser();
    if (isset($current_user)){
      Flash::addMessage("error", "You are already logged in");
      self::redirect_to("/");
      return;
    }
    
    $presenter = self::initializePresenter(array("page_name" => "Register"));
    $template = "views/users/new.php";
    $right_rail = "views/users/_registration_info.php";
    $user = new User();
    include("views/layouts/application.php");
  }
  
  function _create($params=array()){
    $current_user = self::getCurrentUser();
    if (isset($current_user)){
      Flash::addMessage("error", "You are already logged in");
      self::redirect_to("/");
      return;
    }
    
    $user = new User($_POST["user"]);
    if ($user->save()) {
      self::redirect_to("/");
      Flash::addMessage("success", "You have successfully registered");
      $_SESSION["user"] = $user->id;
    } else {
      $user->errors->inspect();
      Flash::addMessage("error", "Ensure that you have filled out the registration form fully", true);
      $presenter = self::initializePresenter(array("page_name" => "Register"));
      $template = "views/users/new.php";
      $right_rail = "views/users/_registration_info.php";
      include("views/layouts/application.php");
    }
  }
  
  function _edit($params=array()) {
    $current_user = self::getCurrentUser();
    $user = User::findOne(array('_id' => $params["id"]));
    if ($user->id == $current_user->id) {
      $template = "views/users/edit.php";
      $presenter = self::initializePresenter(array("page_name" => "Register"));
      include("views/layouts/application.php");
    } else {
      echo "FOO";
    }
    
    
  }
  
}

?>