<?php

require 'global.php';
$page = new \Page\admin();
$page->setFilename("member.php");
$page->startSession();
$page->checkLogin();

$page->addHeaderHTML('<meta charset="utf-8"/>');
$page->addHeaderHTML('<meta name="viewport" content="width=device-width, initial-scale=1"/>');
$page->setPageTitle(\Config\Config::get("sitename") . ' - Member');
$page->setPageDescription($page->getPageTitle());

//Fonts
$page->addCSS("https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css", false);

//Style
$page->addCSS("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css", false);
$page->addCSS("main.css");
$page->addCSS("orange.css");
$page->addCSS("extra.css");

$page->renderHeader();
$page->echoHeader();

if (!isset($_GET['p'])) {
  $_GET['p'] = "profile";
}

$p = $_GET['p'];
?>

  <!-- Navigation include -->
<?php include 'elements/header.php'; ?>

  <div class="container">
    <p>Welcome back <b><?= $_SESSION['user']['displayName'] ?></b>.</p>
  </div>

  <div class="container">
    <ul class="nav nav-pills col-md-12 pushdown">
      <li role="presentation" class="active"><a href="<?= $page->getFilename() ?>?p=profile">Profile</a></li>
      <li role="presentation"><a href="#">Messages</a></li>
    </ul>
  </div>



<?php
include 'elements/memberprofile.php';
include 'elements/membereprofile.php';
?>

  <!-- Footer / START -->
  <footer class="footer">
    <div class="container">
      <span class="copyright">
       Copyright <?= \Config\Config::get("copyrightyear") ?>. All rights served.
      </span>

      <span class="links">
        <a href="#">Terms of service</a>
        <a href="#">Privacy policy</a>
      </span>
    </div>
  </footer><!-- Footer / END -->

<?php
$page->addFooterJSifIE9("https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js", false);
$page->addFooterJSifIE9("https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js", false);
$page->addFooterJS("https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js", false);
$page->addFooterJS("main.js");
$page->addFooterJS("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js", false);
$page->renderFooter();
$page->echoFooter();