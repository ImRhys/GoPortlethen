<?php

require("resources/classloader.php");

if (\Config\Config::get("displayerror")) {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
}

$db = new \Database\db();
$page = new \Page\page();