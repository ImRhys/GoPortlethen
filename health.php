<?php

require 'global.php';

$page->addHeaderHTML('<meta charset="utf-8"/>');
$page->addHeaderHTML('<meta name="viewport" content="width=device-width, initial-scale=1"/>');
$page->setPageTitle(\Config\Config::get("sitename") . ' - Health News');
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

?>

  <!-- Navigation include -->
<?php include 'elements/header.php'; ?>

  <div id="content">
    <section id="register">
      <div class="container">
        <div class="row">
          <div
            class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 md-margin-top">
            <div class="page-subheader text-center">
              <h1>View All News</h1>
              <hr/>
              <p>A wide variety of heath related news articles!</p>
            </div>
          </div>

          <div class="container pushdown">
            <table class="table table-bordered">

              <?php
              $newq = new \Database\query($db);
              $newq->setQuery("SELECT * FROM health_news ORDER BY itemID DESC");
              $newq->runQuery();

              $delete = "";
              $access = new \Database\Queries\accesslevel($db);
              $access->runQuery();

              if (isset($_GET['d']) && is_numeric(intval($_GET['d']))) {
                if (isset($_SESSION['user']) && $access->getAccessLevelIDByName($_SESSION['user']['accessName']) > 8) {
                  $qq = new \Database\Queries\user($db);
                  $qq->quickQuery("DELETE FROM health_news WHERE itemID = :id", [":id" => $_GET['d']]);
                  header("Location: health.php");
                }
              }
              ?>

              <?php foreach ($newq->getResult() as $thing) { ?>
                <tr>
                  <td>
                    <h4>
                      <?php
                      if (isset($_SESSION['user']) && $access->getAccessLevelIDByName($_SESSION['user']['accessName']) > 8) {
                        echo '<a href="health.php?d='. $thing['itemID'] . '"><button class="btn btn-default btn-xs">Delete</button></a>';
                      }
                      ?>
                      <?= $thing['title'] ?>
                    </h4>

                    <p><?= $thing['content'] ?></p>
                  </td>
                </tr>
              <?php } ?>
            </table>
          </div>
          <!-- Row / END -->
        </div>
        <!-- Container / END -->
      </div>
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