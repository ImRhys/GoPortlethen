<?php

require 'global.php';

$page->setAllMeta("Clubs", "clubs of clubness", "lots,of,clubs");

$page->addCSS("bootstrap.css");
$page->addCSS("extra.css");

$page->renderHeader();
$page->echoHeader();

$query = new \Database\Queries\clubs($db);
$query->easyRun();
$result = $query->getResult();

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

    <form class="form-group">
      <fieldset>
        <div class="form-inline">
          <div class="form-group">
            <button id="search" name="search" class="btn btn-default">Search</button>
          </div>

          <div class="form-group">
            <input id="textinput" name="textinput" type="text" placeholder="Search Clubs" class="form-control input-md">
          </div>

          <div class="form-group">
            <select id="selectbasic" name="selectbasic" class="form-control scrollable-dropdown">
              <option value="1">Option one</option>
              <option value="2">Option two</option>
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
      <?php foreach ($result as $thing) { ?>
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
          <a href="<?= $query->getPaginationPrevious("clubs.php") ?>" aria-label="Previous" title="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?= $query->generatePaginationLinks("clubs.php") ?>
        <li>
          <a href="<?= $query->getPaginationNext("clubs.php") ?>" aria-label="Next" title="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
        <li>
          <a href="<?= $query->getPaginationLast("clubs.php") ?>" aria-label="Next" title="Last">
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