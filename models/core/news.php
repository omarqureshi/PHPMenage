<?php


class News extends Content {

  static function collelction_name() {
    return "News";
  }

  public function attribute_mappings() {
    array_merge(parent::array_mappings, array());
  }

}

?>