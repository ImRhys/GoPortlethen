<?php

namespace Database\Queries;


class accesslevel extends \Database\query {

  function __construct(\Database\db $db) {
    $this->setDBHandle($db);
    $this->setQuery("SELECT * FROM access_level");
  }

  public function getAccessLevelByID($id) {
    $this->runQuery();
    foreach ($this->getResult() as $val => $key) {
      if ($key['levelCode'] == $id) {
        return $key;
      }
    }
  }

}