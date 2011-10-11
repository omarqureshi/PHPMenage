<?php

  /* Database */
  include("config/connection.php");
  
  /* Core Classes */
  include("models/core/errors.php");
  include("models/core/base_mongo.php");
  include("models/core/content.php");
  
  /* Session Handling */
  
  /* Router */
  // echo $_SERVER["REQUEST_METHOD"];
  
  /* Debug */
  
  $a = new Content();
  $a->title = "Test";
  $a->save();
  $a->title = "Changed";
  $a->save();
  var_dump($a);

?>