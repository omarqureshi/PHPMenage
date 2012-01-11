<?php

class ContentController extends BaseController {

  function _index($params=array()) {
    $current_user = self::getCurrentUser();
    $presenter = self::initializePresenter();
    $template = "views/home/index.php";
    $presenter["full_width"] = true;
    include("views/layouts/application.php");
  }

  function _new($params=array()) {
    $current_user = self::getCurrentUser();
    $presenter = self::initializePresenter();
    $template = "views/content/new.php";

    if (isset($_GET['content_type']) && in_array($_GET['content_type'], Content::children())) {
      $klass = new ReflectionClass($_GET['content_type']);
      $klass = $klass->newInstance();
    }

    include("views/layouts/application.php");
  }

}

?>