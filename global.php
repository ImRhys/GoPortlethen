<?php

require("resources/classloader.php");

if (\Config\Config::get("displayerror")) {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
}

$db = new \Database\db("acsm_d8ea6c769e71af1");
$page = new \Page\page();