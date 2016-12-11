<?php

require 'global.php';

$page = new \Page\admin();
$page->startSession();

$page->setAllMeta("Admin Panel", "Administration panel", "");
$page->addCSS("bootstrap.min.css");
$page->addCSS("extra.css");

$page->renderHeader();
$page->echoHeader();
?>

<div class="container">
  <h1>HI THERE</h1>
</div>

<?php
$page->addFooterJS("jquery-3.1.1.min.js");
$page->addFooterJS("bootstrap.min.js");
$page->renderFooter();
$page->echoFooter();