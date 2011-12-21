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
      Flash::addMessage("success", "You have successfully registered");
      $_SESSION["user"] = $user->_id;
      self::redirect_to("/");
    } else {
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
    if ($user->_id == $current_user->_id) {
      $template = "views/users/edit.php";
      $presenter = self::initializePresenter(array("page_name" => "Edit user details"));
      include("views/layouts/application.php");
    } else {
      Flash::addMessage("error", "You do not have access to this page");
      //      self::redirect_to("/");
    }
  }

  function _update($params=array()) {
    $current_user = self::getCurrentUser();
    $user = User::findOne(array('_id' => $params["id"]));

    if ($user->_id == $current_user->_id) {
      if ($user->update($_POST["user"])) {
        Flash::addMessage("success", "Saved your profile");
        self::redirect_to("/users/$current_user->_id/edit");
      } else {
        Flash::addMessage("error", "Could not save your profile", true);
        $presenter = self::initializePresenter(array("page_name" => "Register"));
        $template = "views/users/edit.php";
        include("views/layouts/application.php");
      }
    } else {
      Flash::addMessage("error", "You do not have access to this page");
    }
  }

}

?>