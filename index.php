<?php

  /* Session Handling */
  session_start();

  /* Database */
  include("config/connection.php");

  /* Extensions */
  include("lib/extensions.php");
  include("lib/bcrypt.php");
  include("lib/flash.php");

  /* Core Classes */
  include("models/core/errors.php");
  include("models/core/base_mongo.php");
  include("models/core/content.php");
  include("models/core/user.php");

  /* Controllers */

  include("controllers/base.php");
  include("controllers/maintenance.php");
  include("controllers/home.php");
  include("controllers/session.php");
  include("controllers/users.php");

  /* Form builder */

  include("config/form_builder.php");

  /* Router */

  include("config/router.php");

  $r = new Router();

  /* Restful resources */

  $r->resources("users");

  /* Custom routes */

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $r->map('/', array('controller' => 'home', 'action' => 'index'));
    $r->map('/profile', array('controller' => 'users', 'action' => 'profile'));
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $r->map('/login', array('controller' => 'session', 'action' => 'create'));
    if ($_POST["_method"] == "DELETE") {
      $r->map('/logout', array('controller' => 'session', 'action' => 'destroy'));
    }
  }

  $r->execute();
  $controller_name = ($r->controller_name . "Controller");
  $action = "_" . $r->action;

  if ($r->controller_name && $r->action) {
    $controller_name::$action($r->params);
  } else {
    header("Status: 404 Not Found");
    MaintenanceController::four_oh_four();
  }

?>