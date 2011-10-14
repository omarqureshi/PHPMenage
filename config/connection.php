<?php

  class Database {
    
    private static $instance;

    private function __construct(){}

    public static function database() {
      if (!isset(self::$instance)) {
        $m = new Mongo(self::connectionString());
        self::$instance = $m->selectDB(self::name());
      }
      return self::$instance;
    }
    
    public function __clone() {
      trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
      trigger_error('Unserializing is not allowed.', E_USER_ERROR);
    }
    
    private function yaml() {
      return syck_load(file_get_contents("config/database.yml"));
    }
    
    private function config() {
      $yaml = self::yaml();
      return $yaml[$_SERVER["PHP_ENVIRONMENT"]];
    }
    
    private function username() {
      $config = self::config();
      if (array_key_exists("username", $config)) {
        return $config["username"];
      }
    }
    
    private function password() {
      $config = self::config();
      if (array_key_exists("password", $config)) {
        return $config["password"];
      }
    }
    
    private function name() {
      $config = self::config();
      if (array_key_exists("name", $config)) {
        return $config["name"];
      } else {
        return "test";
      }
    }
    
    private function host() {
      $config = self::config();
      if (array_key_exists("host", $config)) {
        return $config["host"];
      } else {
        return "localhost";
      }
    }
    
    private function authentication() {
      if (self::username() && self::password()) {
        return self::username() . ":" . self::password();
      }
    }
    
    private function connectionString() {
      if (self::authentication()) {
        return self::authentication() . "@" . self::host();
      } else {
        return self::host();
      }
    }
    
  }
  
?>