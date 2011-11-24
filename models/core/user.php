<?php

  class User extends BaseMongo {
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $crypted_password;
    public $terms_and_conditions;
    
    public function __construct($attributes=array()) {
      parent::__construct($attributes);
      $this->virtual = array("password", "password_confirmation", "terms_and_conditions");
    }
    
    public function before_save() {
      if ($this->new_record()) {
        $this->crypted_password = Bcrypt::hash($this->password);
      }
    }
    
    public function validate() {
      parent::validate();
      if (!$this->name) {
        $this->errors->addError("name", "Enter a name");
      }
      if (!$this->email) {
        $this->errors->addError("email", "Enter an email address");
      } else {
        if ($this->collection()->count(array('email' => $this->email)) > 0) {
          $this->errors->addError("email", "This email address has already been used, pick another");
        }
      }
      if ($this->new_record()) {
        if ($this->terms_and_conditions != "1") {
          $this->errors->addError("terms_and_conditions", "You need to accept the terms and conditions");
        }
        
        if ($this->password) {
          if ($this->password != $this->password_confirmation) {
            $this->errors->addError("password_confirmation", "You must confirm your password");
          }
        } else {
          $this->errors->addError("password", "Enter a password");
        }
        if (!$this->password_confirmation) {
          $this->errors->addError("password_confirmation", "Enter a password confirmation");
        }
        
      }
      return $this->errors->errorFree();
    }
    
    function authenticate($attributes) {
      $user = User::findOne(array('email' => $attributes['email']));
      
      var_dump($user);
      
      if ($user) {
        if (Bcrypt::check($attributes["password"], $user->crypted_password)) {
          return $user;
        } else {
          return NULL;
        }
      } else {
        return NULL;
      }
    }
    
  }
  
?>