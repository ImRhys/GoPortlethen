<?php

require 'global.php';

$query = new \Database\testquery();
$query->setDBHandle($db);
$query->runQuery();
$query = $query->getResult();

echo "<pre>";
print_r($query);
echo "</pre>";