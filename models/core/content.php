<?php

class Content extends BaseMongo {
  
  protected $title;
  protected $start_time;
  protected $end_time;
  protected $published;
  protected $visible;
  
  public function validate() {
    parent::validate();
    if ($this->start_time && $this->end_time && $this->start_time > $this->end_time) {
      $this->errors->addError("start_time", "Should be before the end time");
      $this->errors->addError("end_time", "Should be after the start time");
    }
    
    if ($this->errors->errorFree()) {
      return true;
    }
    return false;
  }
  
}

?>