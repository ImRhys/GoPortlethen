<?php

require 'global.php';

$page->setAllMeta("Clubs", "clubs of clubness", "lots,of,clubs");

$page->addCSS("bootstrap.css");
$page->addCSS("extra.css");

$page->renderHeader();
$page->echoHeader();

$page->startSession();

$genreQuery = new \Database\Queries\genre($db);
$genreQuery->runQuery();

?>

<!--
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
          <li><a href="indexold.php">Home</a></li>
          <li class="active"><a href="clubs.php">Clubs</a></li>
          <li><a href="#">Health and Wellbeing</a></li>
        </ul>
      </div> -->
      <!--/.nav-collapse -->
    <!-- </div>
  </nav> -->



<?php if (isset($_GET['club']) && is_numeric($_GET['club'])) {
  $clubQuery = new \Database\query($db);
  $clubResult = $clubQuery->quickQuery("SELECT * FROM club WHERE clubID = :id", ["id" => $_GET['club']]);
  ?>
  <div class="container pushdown">
    <table class="table table-bordered">
      <?php foreach ($clubResult as $thing) { ?>
        <tr>
          <td colspan="2"><img src="<?= $thing['banner'] ?>" class="img-responsive"/></td>
        </tr>
        <tr>
          <td class="col-md-2 text-right"><b>Club Name</b></td>
          <td><?= $thing['clubName'] ?></td>
        </tr>
        <tr>
          <td class="col-md-2 text-right"><b>Description</b></td>
          <td><?= $thing['description'] ?></td>
        </tr>
        <tr>
          <td class="col-md-2 text-right"><b>Genre</b></td>
          <td><?= $genreQuery->getGenreNameByID($thing['genreID']) ?></td>
        </tr>
        <tr>
          <td class="col-md-2 text-right"><b>Map</b></td>
          <td>MAPPY MAP MAP</td>
        </tr>
      <?php } ?>
    </table>

    <button id="back" name="back" class="btn btn-default">Back</button>
    <?php $page->addFooterRawJS("
    $(document).ready(function(){
        $('#back').click(function(){
          parent.history.back();
          return false;
        });
      });
    ") ?>
  </div>

<?php } else {
  $clubsQuery = new \Database\Queries\clubs($db);
  $clubsQuery->easyRun();
  $clubsResult = $clubsQuery->getResult();
  ?>

  <div class="container pushdown">
    <form class="form-group" action="" method="get">
      <fieldset>
        <div class="form-inline">
          <div class="form-group">
            <button id="search" name="s" class="btn btn-default" value="1">Search</button>
          </div>

          <div class="form-group">
            <input id="textsearch" name="ts" type="text" placeholder="Search Clubs"
                   value="<?= isset($_GET['ts']) ? $_GET['ts'] : "" ?>" class="form-control input-md">
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


    <?php if ($clubsQuery->getNumberOfResults() > 0) { ?>
      <table class="table table-bordered">
        <thead>
        <th>Banner</th>
        <th>Club Name</th>
        <th>Description</th>
        </thead>
        <?php foreach ($clubsResult as $thing) { ?>
          <tr>
            <td class="col-md-3"><a href="clubs.php?club=<?= $thing['clubID'] ?>"><img src="<?= $thing['banner'] ?>"
                                                                                       class="img-responsive"/></a></td>
            <td class="col-md-3"><a href="clubs.php?club=<?= $thing['clubID'] ?>"><?= $thing['clubName'] ?></a></td>
            <td><?= $thing['description'] ?></td>
          </tr>
        <?php } ?>
      </table>
    <?php } else { ?>
      <div class="alert alert-warning" role="alert">No results found.</div>
    <?php } ?>
  </div>

  <?php if ($clubsQuery->getNumberOfResults() > 0) { ?>
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
  <?php } ?>
<?php } ?>
<?php
$page->addFooterJS("jquery-3.1.1.min.js");
$page->addFooterJS("bootstrap.min.js");
$page->renderFooter();
$page->echoFooter();