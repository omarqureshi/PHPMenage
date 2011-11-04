<?php

function humanize($string) {
  return ucwords(str_replace("_", " ", $string));
}

?>