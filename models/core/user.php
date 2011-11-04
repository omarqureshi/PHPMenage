<?php

  class User extends BaseMongo {
    protected $name;
    protected $email;
    protected $password;
    protected $password_confirmation;
    protected $crypted_password;
    protected $terms_and_conditions;
  }
  
  public function __construct($attributes=array()) {
    $this->virtual = array("password", "password_confirmation", "terms_and_conditions");
    parent::__construct($attributes);
  }
  

?>