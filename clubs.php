<?php

require 'global.php';

$page->setAllMeta("Clubs", "clubs of clubness", "lots,of,clubs");

$page->addCSS("bootstrap.css");
$page->addCSS("extra.css");

$page->renderHeader();
$page->echoHeader();

$query = new \Database\Queries\clubs($db);
$query->easyRun();
$query = $query->getResult();

echo "<div class='container pushdown'><pre>";
print_r($query);
echo "</pre></div>";

?>

  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><?= \Config\config::get("sitename") ?></a>
      </div>
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </div>
      <!--/.nav-collapse -->
    </div>
  </nav>

  <div class="container">
    <table class="table table-bordered">
      <thead>
      <th>Club Name</th>
      <th>Description</th>
      </thead>
      <?php foreach ($query as $thing) { ?>
        <tr>
          <td><?= $thing['clubName'] ?></td>
          <td><?= $thing['description'] ?></td>
        </tr>
      <?php } ?>
    </table>
  </div>


<?php
$page->addFooterJS("jquery-3.1.1.min.js");
$page->addFooterJS("bootstrap.min.js");
$page->renderFooter();
$page->echoFooter();