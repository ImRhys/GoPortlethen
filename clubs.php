<?php

require 'global.php';

$query = new \Database\testquery();
$query->runQuery();
$query->getResult();

print_r($query);