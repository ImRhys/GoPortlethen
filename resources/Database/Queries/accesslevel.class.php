<?php

namespace Database\Queries;


class accesslevel extends \Database\query {

  function __construct(\Database\db $db) {
    $this->setDBHandle($db);
    $this->setQuery("SELECT * FROM access_level");
  }

  /**
   * Get the access level array by ID
   * @param string $id level ID
   * @return array level table array
   */
  public function getAccessLevelArrayByID($id) {
    $this->runQuery();
    foreach ($this->getResult() as $val => $key) {
      if ($key['levelCode'] == $id) {
        return $key;
      }
    }
  }

  /**
   * Get the access level description by ID
   * @param string $id ID
   * @return string access level description
   */
  public function getAccessLevelNameByID($id) {
    return $this->getAccessLevelArrayByID($id)['description'];
  }


  /**
   * Get the access level array by Description
   * @param string $name access Description
   * @return array level table array
   */
  public function getAccessLevelArrayByName($name) {
    $this->runQuery();
    foreach ($this->getResult() as $val => $key) {
      if ($key['description'] == $name) {
        return $key;
      }
    }
  }

  /**
   * Get the access level Code by Description
   * @param $name Description
   * @return string access level Code
   */
  public function getAccessLevelIDByName($name) {
    return $this->getAccessLevelArrayByName($name)['levelCode'];
  }

  public function generateAccessListOptions($id) {
    $out = "";
    foreach ($this->result as $key => $val) {
      $out .= '<option value="' . $val['levelCode'] . '" ' . ($id === $val['levelCode'] ? 'selected="selected"' : '' ) . '>' . $val['description'] . '</option>';
    }

    return $out;
  }

}