<?php

class SessionController extends BaseController {
  
  function _create($params=array()) {
    $presenter = self::initializePresenter();
    $user = User::authenticate(array('email' => $_POST["email"], 'password' => $_POST["password"]));
    if ($user) {
      $_SESSION["user"] = $user->id;
    } 
    self::return_to("/");
  }
  
}

?>