<?php

require("resources/classloader.php");

$config = new \Config\Config();
$db = new \Database\db();

echo $config->get("sitename");