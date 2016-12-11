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

  /**
   * Generate list of options for the select tags
   * @return string list of options
   */
  public function generateList() {
    $out = "";
    foreach ($this->getResult() as $key => $value) {
      $out .= '<option value="' . $value['genreID'] . '" ' . (isset($_GET['g']) && $_GET['g'] === $value['genreID'] ? 'selected="selected"' : '' ) . '>' . $value['name'] . '</option>';
    }

    return $out;
  }

  /**
   * Get the genre name by the given genre ID
   * @param $id genre ID
   * @return string genre name
   */
  public function getGenreNameByID($id) {
    $out = "";
    foreach ($this->getResult() as $val) {
      if ($val['genreID'] === $id) {
        $out = $val['name'];
        break;
      }
    }
    return $out;
  }

}