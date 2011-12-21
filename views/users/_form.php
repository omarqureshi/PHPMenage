<?php
  $f = new FormBuilder($user, "user", $url, array("method" => $method));
  $f->addFieldSet(array("legend" => $legend, "class" => "hidden"));
  $f->addElement("name", "text", array("autocomplete" => "off"));
  $f->addElement("email", "email");
  if ($user->persisted()) {
    $f->addElement("current_password", "password", array("label" => "Current password", "autocomplete" => "off"));
  }
  if ($user->new_record()) {
    $f->addElement("terms_and_conditions", "checkbox", array("label" => "I accept the <a href=\"#terms-and-conditions\">Terms and Conditions</a>"));
    $f->addElement("password", "password", array("autocomplete" => "off"));
    $f->addElement("password_confirmation", "password", array("autocomplete" => "off"));
  } else {
    $f->addElement("password", "password", array("label" => "New password", "autocomplete" => "off"));
    $f->addElement("password_confirmation", "password", array("label" => "Confirm new password", "autocomplete" => "off"));
  }
  $f->insertHTML("<div class=actions>");
  $f->addSubmit($submit);
  $f->insertHTML("</div>");
  $f->render();
?>