<?php

class BasicAbstractFormElementFactory {

  public static function build($type, $name, $value, $attributes=array()) {
    switch($type) {
    case "hidden":
      return new BasicHiddenFieldElement($name, $value, $attributes);
      break;
    }
  }

}

class BasicHiddenFieldElement {
  protected $name;
  protected $value;
  protected $attributes;


  public function __construct($name, $value, $attributes) {
    $this->name = $name;
    $this->value = $value;
    $this->attributes = $attributes;
  }

  public function toHTML() {
    $input = "<input type=hidden name={$this->name} ";
    if ($this->value) {
      $input .= "value=\"{$this->value}\" ";
    }
    $input .= "/>";
    return $input;
  }
}


class AbstractFormElementFactory {

  public static function build($object, $object_name, $method, $type, $attributes=array()){
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

    $classes = array("clearfix");
    $error = $this->object->errors->errorsFor($this->method);
    if ($error) {
      $classes[]= "error";
      $help = "<br /><span class=help-inline>$error</span>";
    } else {
      $help = "";
    }
    $classes = implode(" ", $classes);

    $output = "
<div class=\"$classes\">
<div class=input>
<ul class=inputs-list>
<li>
<label>
<input type=checkbox name={$this->elementName()} id={$this->elementID()} value=1";
    if ($this->value()) {
      $output .= " checked=checked";
    }
    $output .= " />
<span>$this->label</span>
$help
</label>
</li>
</ul>
</div>
</div>";
    return $output;
  }
}

class PasswordFieldElement extends FormElement {
}

class EmailFieldElement extends FormElement {
}

class TextFieldElement extends FormElement {
}


class FormElement {

  protected $type;
  protected $object;
  protected $method;
  protected $label;
  protected $id;
  protected $attributes;

  public function __construct($object, $object_name, $method, $type, $attributes=array()) {
    $this->object = $object;
    $this->object_name = $object_name;
    $this->method = $method;
    $this->type = $type;
    if (array_key_exists("label", $attributes)) {
      $this->label = $attributes["label"];
      unset($attributes["label"]);
    } else {
      $this->label = humanize($this->method);
    }
    $this->attributes = $attributes;
  }

  public function elementID() {
    return $this->object_name . "_" . $this->method;
  }

  public function elementName() {
    return $this->object_name . "[" . $this->method . "]";
  }

  public function mainWrapper($html) {
    $classes = array("clearfix");
    $error = $this->object->errors->errorsFor($this->method);
    if ($error) {
      $classes[]= "error";
      $help = "<span class=help-inline>$error</span>";
    } else {
      $help = "";
    }
    $classes = implode(" ", $classes);

    return "
<div class=\"$classes\">
<label for={$this->elementID()}>{$this->label}</label>
<div class=input>
$html
$help
</div>
</div>
";

  }

  public function baseTextInput() {
    $output = "<input type={$this->type} name={$this->elementName()} id={$this->elementID()}";

    foreach($this->attributes as $key => $value) {
      $output .= " $key=\"{$value}\"";
    }

    $value = $this->value();
    if (!empty($value)){
      $output .= " value=\"{$value}\"";
    }
    $output .= " />";
    return $output;
  }

  public function toHTML() {
    return $this->mainWrapper($this->baseTextInput());
  }

  public function value() {
    $input = $this->valueFromInput();
    if ($input){
      return $input;
    }
    $obj = $this->valueFromObject();
    if ($obj){
      return $obj;
    }
    return "";
  }

  public function valueFromInput() {
    if (array_key_exists($this->object_name, $_REQUEST)) {
      $main_hash = $_REQUEST[$this->object_name];
      if (array_key_exists($this->method, $main_hash)) {
        return $main_hash[$this->method];
      }
    }
    return false;
  }

  public function valueFromObject() {
    $method = $this->method;
    return $this->object->$method;
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

  public function __construct($object, $object_name, $action, $attributes=array()) {
    $this->attributes = $attributes;
    $this->fieldsets = array();
    $this->object = $object;
    $this->object_name = $object_name;
    $this->action = $action;
    if (array_key_exists("method", $this->attributes)) {
      $this->method = $attributes["method"];
    }
    if (!$this->method) {
      $this->method = "post";
    } else {
      if ($this->method == "put" || $this->method == "delete") {
        $this->addBasicElement("hidden", "_method", $this->method, $attributes);
        $this->method = "post";
      }
    }


  }

  public function addElement($method, $type, $attributes=array()) {
    $element = AbstractFormElementFactory::build($this->object, $this->object_name, $method, $type, $attributes);
    $this->elements[]= $element;
  }

  public function addBasicElement($type, $name, $value, $attributes=array()) {
    $element = BasicAbstractFormElementFactory::build($type, $name, $value, $attributes);
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
    $output = "<form action=$this->action";
    $output .= " method=$this->method";
    if ($this->class){
      $output .= " class=$this->class";
    }
    if ($this->id) {
      $output .= " id=$this->id";
    }
    $output .= " >\n";

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