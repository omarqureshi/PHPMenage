<?php

class BaseMongo {
  protected $id;
  protected $virtual;
  protected $created_at;
  protected $updated_at;
  public $errors;

  function __construct ($attList=array()) {
    $reflection = new ReflectionObject($this);
    foreach ($attList as $attName => $attValue) {
      $attObj = $reflection->getProperty($attName);
      $attObj->setAccessible(true);
      $attObj->setValue($this, $attValue);
    }
    if (!isset($this->virtual)) {
      $this->virtual = array();
    }
  }
  
  function attributes() {
    $reflection = new ReflectionObject($this);
    $properties = $reflection->getProperties();
    $results = array();
    foreach($properties as $property) {
      if ($property->getName() != "id") {
        $property->setAccessible(true);
        $results[$property->getName()] = $property->getValue($this);
      }
    }
    return $results;
  }
  
  function __set($name, $value) {
    switch($name) {
      case preg_match('/\[\d*i\]/', $name):
        break;
      default:
        $this->$name = $value;
    }
  }
  
  public function collection() {
    $db = Database::database();
    return $db->selectCollection(get_class($this));
  }
  
  public function save() {
    if ($this->validate()) {
      $attributes = $this->attributes();
      self::collection()->save($attributes);
      $this->id = $attributes["_id"];
      return true;
    }
    return false;
  }
  
  public function validate() {
    $this->errors = new Errors();
    return true;
  }

}

?>