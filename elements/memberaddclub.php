<?php

$access = new \Database\Queries\accesslevel($db);
$access->runQuery();
?>
<div id="content">
  <div class="container pushdown">

    <?php if ($access->getAccessLevelIDByName($_SESSION['user']['accessName']) > 8) { ?>

      <sectiond id="editclub">
        <div class="panel panel-default">
          <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left">Clubs Manager - Add Club</h3>

            <div class="pull-right">
              <button id="back" class="btn btn-default btn-xs">Back</button>
              <button id="submit" class="btn btn-default btn-xs">Save</button>
            </div>
          </div>
        </div>

        <?php

        if (!empty($_POST)) {

          if (!isset($_POST['clubName'])) {
            die("Missing club name.");
          }

          if (!isset($_POST['description'])) {
            die("Missing club description.");
          }

          if (!isset($_POST['adminID'])) {
            die("Missing club admin ID.");
          }

          if (!isset($_POST['genreID'])) {
            die("Missing genre ID.");
          }

          if (!isset($_POST['banner'])) {
            die("Missing banner.");
          }

          $updquery = new \Database\Queries\clube($db);

          $arr = [
            ":clubName" => $_POST['clubName'],
            ":description" => $_POST['description'],
            ":adminID" => $_POST['adminID'],
            ":genreID" => $_POST['genreID'],
            ":banner" => $_POST['banner']
          ];

          $updquery->setQuery("
              INSERT INTO club
              (
                clubName,
                description,
                adminID,
                genreID,
                banner
              )
              VALUES
              (
                :clubName,
                :description,
                :adminID,
                :genreID,
                :banner
              )
            "
          );

          $updquery->setParameters($arr);
          $updquery->runQuery();

          //If query succeeded
          if ($updquery->getResult() > 0) {
            echo '<div class="alert alert-success">Successfully added.</div>';
          }
        }
        ?>

        <?= $page->startForm($page->getFilename() . "?p=addclub", "change") ?>
        <table class="table">
          <tr>
            <td class="col-md-2 text-right"><b>Club Name</b></td>
            <td>
              <div class="controls">
                <input name="clubName" type="text" class="form-control input"/>
              </div>
            </td>
          </tr>

          <tr>
            <td class="col-md-2 text-right"><b>Description</b></td>
            <td>
              <div class="form-group">
                <div class="controls">
                  <input name="description" type="text" class="form-control input"/>
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td class="col-md-2 text-right"><b>Admin</b></td>
            <td>
              <div class="form-group">
                <div class="controls">
                  <select name="adminID" class="form-control scrollable-dropdown">
                    <?php
                    $qq = new \Database\query($db);
                    $qq->quickQuery("SELECT userID, userName FROM users ORDER BY accessLevel DESC, userName ASC", []);
                    $qq->runQuery();

                    foreach ($qq->getResult() as $key => $value) {
                      echo '<option value="' . $value['userID'] . '" ' . '>' . $value['userName'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td class="col-md-2 text-right"><b>Genre</b></td>
            <td>
              <div class="form-group">
                <select name="genreID" class="form-control scrollable-dropdown">
                  <?php
                  $genreq = new \Database\Queries\genre($db);
                  $genreq->runQuery();
                  echo $genreq->generateListFromID("");
                  ?>
                </select>
              </div>
            </td>
          </tr>

          <tr>
            <td class="col-md-2 text-right"><b>Banner</b></td>
            <td>
              <div class="form-group">
                <input name="banner" type="text" class="form-control input"/>
              </div>
            </td>
          </tr>
        </table>
        <?= $page->endForm() ?>

      </sectiond>
      <?php
      $page->addFooterRawJS("$(document).ready(function() { $('#submit').click(function(){ $('#change').submit()})})");
      $page->addFooterRawJS("$(document).ready(function(){ $('#back').click(function(){ parent.history.back(); return false; });});");
      ?>

    <?php } else { ?>
      <div class="alert alert-warning">You do not have access to this page.</div>
    <?php } ?>
  </div>
</div>
