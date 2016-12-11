<?php

require 'global.php';

$page->setAllMeta("Clubs", "clubs of clubness", "lots,of,clubs");

$page->addCSS("bootstrap.css");
$page->addCSS("extra.css");

$page->renderHeader();
$page->echoHeader();

$clubsQuery = new \Database\Queries\clubs($db);
$clubsQuery->easyRun();
$clubsResult = $clubsQuery->getResult();

$genreQuery = new \Database\Queries\genre($db);
$genreQuery->runQuery();

echo "<div class='container pushdown'><pre>";
//print_r($result);
print_r($_GET);
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

  <div class="container pushdown">

    <form class="form-group" action="" method="get">
      <fieldset>
        <div class="form-inline">
          <div class="form-group">
            <button id="search" name="s" class="btn btn-default" value="1">Search</button>
          </div>

          <div class="form-group">
            <input id="textsearch" name="ts" type="text" placeholder="Search Clubs" value="<?= isset($_GET['ts']) ? $_GET['ts'] : "" ?>" class="form-control input-md">
          </div>

          <div class="form-group">
            <select id="genre" name="g" class="form-control scrollable-dropdown">
              <option value="0">Genre</option>
              <option value="0"></option>
              <?= $genreQuery->generateList() ?>
            </select>
          </div>
        </div>

      </fieldset>
    </form>


    <table class="table table-bordered">
      <thead>
      <th>Banner</th>
      <th>Club Name</th>
      <th>Description</th>
      </thead>
      <?php foreach ($clubsResult as $thing) { ?>
        <tr>
          <td class="col-md-3"><img src="<?= $thing['banner'] ?>" class="img-responsive"/></td>
          <td class="col-md-3"><?= $thing['clubName'] ?></td>
          <td><?= $thing['description'] ?></td>
        </tr>
      <?php } ?>
    </table>
  </div>

  <div class="text-center">
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <li>
          <a href="clubs.php<?= \helper\url::buildMissingGets("page", 1) ?>" aria-label="Previous" title="First">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <li>
          <a href="<?= $clubsQuery->getPaginationPrevious("clubs.php") ?>" aria-label="Previous" title="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?= $clubsQuery->generatePaginationLinks("clubs.php") ?>
        <li>
          <a href="<?= $clubsQuery->getPaginationNext("clubs.php") ?>" aria-label="Next" title="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
        <li>
          <a href="<?= $clubsQuery->getPaginationLast("clubs.php") ?>" aria-label="Next" title="Last">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
<?php
$page->addFooterJS("jquery-3.1.1.min.js");
$page->addFooterJS("bootstrap.min.js");
$page->renderFooter();
$page->echoFooter();