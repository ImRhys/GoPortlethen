<?php

namespace Database;


class testquery extends query {

  function __construct() {
    $this->setQuery("select * from test");
  }
}