<?php

require 'global.php';

$page->addHeaderHTML('<meta charset="utf-8"/>');
$page->addHeaderHTML('<meta name="viewport" content="width=device-width, initial-scale=1"/>');
$page->setPageTitle(\Config\Config::get("sitename") . ' - View All Clubs');
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

$page->startSession();

$genreQuery = new \Database\Queries\genre($db);
$genreQuery->runQuery();

?>

  <!-- Navigation include -->
<?php include 'header.php'; ?>

  <div id="content">
    <section id="register">
      <div class="container">
        <div class="row">
          <div
            class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 md-margin-top">
            <div class="page-subheader text-center">
              <h1>View All Clubs</h1>
              <hr/>
              <p>A wide variety of clubs in Portlethen and surrounding areas!</p>
            </div>

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
                        <td class="col-md-3"><a href="clubs.php?club=<?= $thing['clubID'] ?>"><img
                              src="<?= $thing['banner'] ?>"
                              class="img-responsive"/></a></td>
                        <td class="col-md-3"><a
                            href="clubs.php?club=<?= $thing['clubID'] ?>"><?= $thing['clubName'] ?></a></td>
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
                        <a href="clubs.php<?= \helper\url::buildMissingGets("page", 1) ?>" aria-label="Previous"
                           title="First">
                          <span aria-hidden="true">&laquo;</span>
                        </a>
                      </li>
                      <li>
                        <a href="<?= $clubsQuery->getPaginationPrevious("clubs.php") ?>" aria-label="Previous"
                           title="Previous">
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

          </div>
        </div>
        <!-- Row / END -->
      </div>
      <!-- Container / END -->
    </section>
  </div><!-- Content / END -->

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