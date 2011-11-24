<?php

  class Errors {
    
    public $errors;
    
    public function __construct() {
      $this->errors = array();
    }
    
    public function errorFree() {
      return empty($this->errors);
    }
    
    public function addError($attribute, $message) {
      if (!array_key_exists($attribute, $this->errors)) {
        $this->errors[$attribute] = array();
      }
      $this->errors[$attribute][] = $message;
      return true;
    }
    
    public function errorsFor($attribute) {
      if (array_key_exists($attribute, $this->errors)) {
        return $this->errors[$attribute][0];
      }
      return NULL;
    }
    
    public function inspect() {
      return $this->errors;
    }
    
  }

?>