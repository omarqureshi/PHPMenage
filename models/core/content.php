<?php

class Content extends BaseMongo {

  public $title;
  public $start_time;
  public $end_time;
  public $published;

  public function attribute_mappings() {
    return array('title' => 'String',
                 'start_time' => 'DateTime',
                 'end_time' => 'DateTime',
                 'published' => 'Boolean');
  }

  public function attribute_order() {
    return array('title', 'published', 'start_time', 'end_time');
  }

  public function validate() {
    parent::validate();
    if (!$this->start_time) {
      $this->errors->addError("start_time", "Should be set");
    }

    if ($this->start_time && $this->end_time && $this->start_time > $this->end_time) {
      $this->errors->addError("start_time", "Should be before the end time");
      $this->errors->addError("end_time", "Should be after the start time");
    }
    return $this->errors->errorFree();
  }

  function __set($name, $value) {
    switch($name) {
      case preg_match('/\[\d*i\]/', $name):
      case "start_date":
      case "end_date":
      default:
        parent::__set($name, $value);
    }
  }

  static function collection_name() {
    return "Content";
  }

  public static function children() {
    $children  = array();
    foreach(get_declared_classes() as $class){
      $klass = new ReflectionClass($class);
      if ($klass->isSubclassOf("Content")) {
        $children[]= $klass->getName();
      }
    }
    return $children;
  }

}

?>