<?php

class SessionController extends BaseController {

  function _create($params=array()) {
    $presenter = self::initializePresenter();
    $user = User::authenticate(array('email' => $_POST["email"], 'password' => $_POST["password"]));
    if ($user) {
      Flash::addMessage("success", "Thanks for logging in", true);
      $_SESSION["user"] = $user->_id;
    } else {
      Flash::addMessage("error", "Check you have entered your email address and password in correctly");
    }
    self::return_to("/");
  }

  function _destroy() {
    $presenter = self::initializePresenter();
    $current_user = self::getCurrentUser();
    if ($current_user) {
      Flash::addMessage("notice", "You have logged out");
      unset($_SESSION["user"]);
    }
    self::return_to("/");
  }

}

?>