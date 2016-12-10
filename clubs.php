<?php

require 'global.php';

$page->setPageTitle("Clubs");
$page->setPageDescription("lots of clubs.");
$page->setPageKeywords("lots, of, clubs");

$page->addCSS("somecssfile.css");
$page->addHeaderJS("somejsfile.js");

$page->renderHeader();
$page->echoHeader();

$query = new \Database\testquery();
$query->setDBHandle($db);
$query->runQuery();
$query = $query->getResult();

echo "<pre>";
print_r($query);
echo "</pre>";

$page->addFooterJS("somejsfile.js");
$page->renderFooter();
$page->echoFooter();