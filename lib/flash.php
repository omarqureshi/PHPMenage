<?php

class Flash {
  
  private static $instance;
  public static $messages;
  
  public function __construct() {
    if (array_key_exists("flash", $_SESSION)) {
      self::$messages = $_SESSION["flash"];
      unset($_SESSION["flash"]);
    } else {
      self::$messages = array("error" => array(), "success" => array(), "notice" => array());
    }
  }
  
  public static function singleton() {
    if (!isset(self::$instance)) {
      $className = __CLASS__;
      self::$instance = new $className;
    }
    return self::$instance;
  }
  
  public function addMessage($type, $message, $now=false) {
    if ($now) {
      self::$messages[$type][]= $message;
    } else {
      if (!array_key_exists("flash", $_SESSION)) {
        $_SESSION["flash"] = array("error" => array(), "success" => array(), "notice" => array());
      }
      $_SESSION["flash"][$type][] = $message;
    }
    
  }
  
  public function __clone() {
    trigger_error('Clone is not allowed.', E_USER_ERROR);
  }

  public function __wakeup() {
    trigger_error('Unserializing is not allowed.', E_USER_ERROR);
  }
  
}

new Flash();

?>