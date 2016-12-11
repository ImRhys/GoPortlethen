<?php

namespace Database\Queries;


class genre extends \Database\query {

  function __construct(\Database\db $db) {
    $this->setDBHandle($db);
    $this->setQuery("
      SELECT * FROM genre
      ORDER BY name ASC
    ");
  }

  public function generateList() {
    $out = "";
    foreach ($this->getResult() as $key => $value) {
      $out .= '<option value="' . $value['genreID'] . '" ' . (isset($_GET['g']) && $_GET['g'] === $value['genreID'] ? 'selected="selected"' : '' ) . '>' . $value['name'] . '</option>';
    }

    return $out;
  }

}