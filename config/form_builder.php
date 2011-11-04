<?php

class AbstractFormElementFactory {
  
  public function build($object, $object_name, $method, $type, $attributes=array()){
    switch($type) {
      case "text":
        return new TextFieldElement($object, $object_name, $method, $type, $attributes);
        break;
      case "email":
        return new EmailFieldElement($object, $object_name, $method, $type, $attributes);
        break;
      case "password":
        return new PasswordFieldElement($object, $object_name, $method, $type, $attributes);
        break;
      case "checkbox":
        return new CheckboxFieldElement($object, $object_name, $method, $type, $attributes);
        break;
    }
  }
  
}

class CheckboxFieldElement extends FormElement {
  
  public function toHTML() {
    $input =  "<input type=checkbox name={$this->elementName()} id={$this->elementID()} />";
    return "
<div class=clearfix>
<div class=input>
<ul class=inputs-list>
<li>
<label>
<input type=checkbox name={$this->elementName()} id={$this->elementID()} value=1 />
<span>$this->label</span>
</label>
</li>
</ul>
</div>
</div>
";
  }
}

class PasswordFieldElement extends FormElement {
  
  public function toHTML() {
    $input =  "<input type=password name={$this->elementName()} id={$this->elementID()} />";
    return $this->mainWrapper($input);
  }
}

class EmailFieldElement extends FormElement {
  
  public function toHTML() {
    $input =  "<input type=email name={$this->elementName()} id={$this->elementID()} />";
    return $this->mainWrapper($input);
  }
}

class TextFieldElement extends FormElement {
  
  public function toHTML() {
    $input =  "<input type=text name={$this->elementName()} id={$this->elementID()} />";
    return $this->mainWrapper($input);
  }
  
}


class FormElement {
  
  protected $type;
  protected $object;
  protected $method;
  protected $label;
  protected $id;
  
  public function __construct($object, $object_name, $method, $type, $attributes=array()) { 
    $this->object = $object;
    $this->object_name = $object_name;
    $this->method = $method;
    $this->type = $type;
    if (array_key_exists("label", $attributes)) {
      $this->label = $attributes["label"];
    } else {
      $this->label = humanize($this->method);
    }
  }

  public function elementID() {
    return $this->object_name . "_" . $this->method;
  }

  public function elementName() {
    return $this->object_name . "[" . $this->method . "]";
  }

  public function mainWrapper($html) {
    return "
<div class=clearfix>
<label for={$this->elementID()}>{$this->label}</label>
<div class=input>
$html
</div>
</div>
";

  }
  
}

class SubmitButton {
  protected $value;
  
  public function __construct($value, $attributes=array()) {
    $this->value = $value;
  }
  
  public function toHTML() {
    $classes = "btn primary";
    return "<input type=submit name=commit value={$this->value} class=\"$classes\">";
  }
}

class FormFieldset {
  
  private $element_start_index;
  private $legend;
  
  public function __construct($attributes=array()) {
    $this->element_start_index = $attributes["element_start_index"];
    $this->legend = $attributes["legend"];
  }

  public function startHTML() {
    return "<fieldset><legend>$this->legend</legend>";
    
  }

  public function endHTML() {
    return "</fieldset>";
  }

  
}

class Snippet {
  protected $html;
  
  public function __construct($html) {
    $this->html = $html;
  }
  
  public function toHTML() {
    return $this->html;
  }
}

class FormBuilder {
  
  private $action;
  private $method;
  private $elements;
  private $fieldsets;
  private $id;
  private $class;
  
  public function __construct($object, $object_name, $action) {
    $this->attributes = array();
    $this->fieldsets = array();
    $this->object = $object;
    $this->object_name = $object_name;
    $this->action = $action;
  }
  
  public function addElement($method, $type, $attributes=array()) {
    $element = AbstractFormElementFactory::build($this->object, $this->object_name, $method, $type, $attributes);
    $this->elements[]= $element;
  }
  
  public function addSubmit($value) {
    $element = new SubmitButton($value);
    $this->elements[]= $element;
  }
  
  public function addFieldSet($attributes=array()) {
    $count = array("element_start_index" => count($this->elements));
    $attr = array_merge($attributes, $count);
    $this->fieldsets[]= new FormFieldset($attr);
  }
  
  public function insertHTML($html){
    $snippet = new Snippet($html);
    $this->elements[]= $snippet;
  }
  
  public function render() {
    $output = "<form action=$this->action method=$this->method class=$this->class id=$this->id>\n";
    $fieldset_count = count($this->fieldsets);
    $j = 0;
    while($j < $fieldset_count) {
      $current_fieldset = $this->fieldsets[$j];
      $output .= $current_fieldset->startHTML();
      if ($j+1 < $fieldset_count) {
        $next_fieldset = $this->fieldsets[$j+1];
      }
      for($i = 0; $i < count($this->elements); $i++) {
        if (isset($next_fieldset) && $next_fieldset->element_start_index == $i) {
          $output .= $this->fieldsets[$j]->endHTML();
          $j++;
          $output .= $this->fieldsets[$j]->startHTML();
        }
        $output .= $this->elements[$i]->toHTML();
      }
      $output .= $this->fieldsets[$j]->endHTML();
      $j++;
    }
    $output .= "</form>";
    echo $output;
  }
  
}

?>