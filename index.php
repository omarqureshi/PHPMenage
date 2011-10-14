<?php

  /* Database */
  include("config/connection.php");
  
  /* Core Classes */
  include("models/core/errors.php");
  include("models/core/base_mongo.php");
  include("models/core/content.php");
  
  /* Session Handling */
  
  /* Controllers */
  
  include("controllers/base.php");
  include("controllers/home.php");
  include("controllers/session.php");
  
  /* Router */
  
  include("config/router.php");
  
  $r = new Router();
  $r->map('/', array('controller' => 'home', 'action' => 'index'));
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $r->map('/login', array('controller' => 'session', 'action' => 'new'));
  }
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $r->map('/login', array('controller' => 'session', 'action' => 'create'));
  }
  
  
  
  
  $r->execute();
  $controller_name = ($r->controller_name . "Controller");
  $action = $r->action;
  
  $controller_name::$action();
  
?>