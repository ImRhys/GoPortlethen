<?php

namespace Database\Queries;


class clubs extends \Database\query {

  function __construct(\Database\db $db) {
    $this->setDBHandle($db);
    $this->setQuery("
      SELECT * FROM club
      LIMIT 10
    ");
  }
}