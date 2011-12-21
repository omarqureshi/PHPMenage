<?php

  class User extends BaseMongo {
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $current_password;
    public $crypted_password;
    public $terms_and_conditions;

    public function __construct($attributes=array()) {
      parent::__construct($attributes);
      $this->virtual = array("password", "password_confirmation", "current_password", "terms_and_conditions");
    }

    public function before_save() {
      if ($this->new_record()) {
        $this->setPassword();
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
        if ($this->collection()->count(array('email' => $this->email), array('_id' => array('$ne' => $this->id))) > 0) {
          $this->errors->addError("email", "This email address has already been used, pick another");
        }
      }
      if ($this->new_record()) {
        if ($this->terms_and_conditions != "1") {
          $this->errors->addError("terms_and_conditions", "You need to accept the terms and conditions");
        }
        $this->checkPassword();
      }

      if ($this->persisted()) {
        if ($this->current_password && $this->password && $this->password_confirmation) {
          if (Bcrypt::check($this->current_password, $this->crypted_password)) {
            $this->checkPassword();
            $this->setPassword();
          } else {
            $this->errors->addError("current_password", "Current password is not correct");
          }
        }
      }
      return $this->errors->errorFree();
    }

    function setPassword() {
      $this->crypted_password = Bcrypt::hash($this->password);
    }

    function checkPassword() {
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

    function authenticate($attributes) {
      $user = User::findOne(array('email' => $attributes['email']));
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