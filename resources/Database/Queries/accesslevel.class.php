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

}