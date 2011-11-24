<?php
  $f = new FormBuilder($user, "user", "/users");
  $f->addFieldSet(array("legend" => $legend, "class" => "hidden"));
  $f->addElement("name", "text");
  $f->addElement("email", "email");
  if ($user->new_record()) {
    $f->addElement("password", "password");
    $f->addElement("password_confirmation", "password");
    $f->addElement("terms_and_conditions", "checkbox", array("label" => "I accept the <a href=\"#terms-and-conditions\">Terms and Conditions</a>"));
  }
  $f->insertHTML("<div class=actions>");
  $f->addSubmit($submit);
  $f->insertHTML("</div>");
  $f->render();
?>