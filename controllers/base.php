<?php

class BaseController {

  function initializePresenter($attributes=array()) {
    $presenter = array();
    $presenter["application_name"] = "Content M&eacute;nage";
    $presenter["full_width"] = false;
    if (array_key_exists("page_name", $attributes)) {
      $presenter["page_name"] = $attributes["page_name"];
    } else {
      $presenter["page_name"] = $presenter["application_name"];
    }

    return $presenter;
  }

  function return_to($params=array(), $default="/") {
    if (array_key_exists("return_to", $params)) {
      $return_to = $params["return_to"];
    } else {
      $return_to = $default;
    }
    header("Location: $return_to");
  }

  function redirect_to($location) {
    header("Location: $location");
  }

  function getCurrentUser() {
    if (array_key_exists("user", $_SESSION)) {
      $user = User::findOne(array('_id' => $_SESSION["user"]));
      return $user;
    }
  }

}

?>