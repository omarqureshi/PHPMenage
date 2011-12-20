<?php

class BaseMongo {
  public $_id;
  protected $virtual;
  public $created_at;
  public $updated_at;
  public $errors;

  public function __construct ($attList=array()) {
    $this->setAttributes($attList);
    $this->virtual = array();
    $this->errors = new Errors();
  }

  public function update($attList) {
    $this->setAttributes($attList);
    return $this->save();
  }

  public function attributes() {
    $reflection = new ReflectionObject($this);
    $properties = $reflection->getProperties();
    $results = array();
    $exclude_list = array("virtual", "errors");
    if ($this->new_record()) {
      $exclude_list[]= "_id";
    }

    foreach($properties as $property) {
      if (!in_array($property->getName(), $exclude_list)
       && !in_array($property->getName(), $this->virtual))
      {
        $property->setAccessible(true);
        $results[$property->getName()] = $property->getValue($this);
      }
    }
    return $results;
  }

  public function setAttributes($attList=array()) {
    $reflection = new ReflectionObject($this);
    foreach ($attList as $attName => $attValue) {
      $attObj = $reflection->getProperty($attName);
      $attObj->setAccessible(true);
      $attObj->setValue($this, $attValue);
    }
  }

  public function __set($name, $value) {
    if (trim($value) === ""){
      $value = NULL;
    }
    switch($name) {
      case preg_match('/\[\d*i\]/', $name):
        break;
      default:
        $this->$name = $value;
    }
  }

  public function collection() {
    $db = Database::database();
    return $db->selectCollection(static::collection_name());
  }

  public function save() {
    if ($this->validate()) {
      $this->before_save();
      $attributes = $this->attributes();
      $this->collection()->save($attributes);
      return true;
    }
    return false;
  }

  public function validate() {
    $this->before_validate();
    return true;
  }

  public function before_save() {
    return true;
  }

  public function before_validate() {
    return true;
  }

  public static function collection_name() {
    return pluralize(get_called_class());
  }

  public function persisted() {
    return !!$this->_id;
  }

  public function new_record() {
    return !$this->persisted();
  }

  public static function findOne($attributes) {
    if (array_key_exists("_id", $attributes)) {
      $attributes["_id"] = new MongoId($attributes["_id"]);
    }
    $return_val = static::collection()->findOne($attributes);
    if (isset($return_val["_id"])) {
      return static::createObject($return_val);
    } else {
      return null;
    }
  }

  public static function createObject($attributes) {
    return new static($attributes);
  }

}

?>