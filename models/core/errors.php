<?php

  class Errors {
    
    public $errors;
    
    public function __construct() {
      $errors = array();
    }
    
    public function errorFree() {
      return empty($errors);
    }
    
    public function addError($attribute, $message) {
      if (!$this->errors[$attribute]) {
        $this->errors[$attribute] = array();
      }
      $this->errors[$attribute][] = $message;
      return true;
    }
    
  }

?>