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
            <h3 class="panel-title pull-left">Clubs Manager - Edit</h3>

            <div class="pull-right">
              <button id="back" class="btn btn-default btn-xs">Back</button>
              <button id="submit" class="btn btn-default btn-xs">Save</button>
            </div>
          </div>
        </div>

        <?php

        $scquery = new \Database\query($db);
        $scquery->setQuery("SELECT * FROM club WHERE clubID = :clubID LIMIT 1");
        $scquery->setParameters([":clubID" => $_GET['c']]);
        $scquery->runQuery();
        $result = $scquery->getResult();

        //If we get nothing back something has gone wrong somewhere
        if (empty($result)) {
          die("An error has occurred.");
        }

        //Swtich our result into the first array returned, makes life a little easier
        $result = $result[0];

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
            ":clubID" => intval($_GET['c']),
            ":clubName" => $_POST['clubName'],
            ":description" => $_POST['description'],
            ":adminID" => $_POST['adminID'],
            ":genreID" => $_POST['genreID'],
            ":banner" => $_POST['banner']
          ];

          $updquery->setQuery("
              UPDATE club
              SET
                clubName = :clubName,
                description = :description,
                adminID = :adminID,
                genreID = :genreID,
                banner = :banner
              WHERE
                clubID = :clubID
            "
          );

          $updquery->setParameters($arr);
          $updquery->runQuery();

          //If query succeeded
          if ($updquery->getResult() > 0) {
            echo '<div class="alert alert-success">Successfully saved.</div>';

            //Rerun query to update page info after change
            $scquery->runQuery();
            $result = $scquery->getResult();
            $result = $result[0];
          } else {
            echo '<div class="alert alert-info">Nothing changed.</div>';
          }
        }
        ?>

        <?= $page->startForm($page->getFilename() . "?p=eclubs&c=" . $_GET['c'], "change") ?>
        <table class="table">
          <tr>
            <td class="col-md-2 text-right"><b>Club Name</b></td>
            <td>
              <div class="controls">
                <input name="clubName" type="text" value="<?= $result['clubName'] ?>"
                       class="form-control input"/>
              </div>
            </td>
          </tr>

          <tr>
            <td class="col-md-2 text-right"><b>Description</b></td>
            <td>
              <div class="form-group">
                <div class="controls">
                  <input name="description" type="text" value="<?= $result['description'] ?>"
                         class="form-control input"/>
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
                      echo '<option value="' . $value['userID'] . '" ' . ($result['adminID'] === $value['userID'] ? 'selected="selected"' : '' ) . '>' . $value['userName'] . '</option>';
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
                  echo $genreq->generateListFromID($result['genreID']);
                  ?>
                </select>
              </div>
            </td>
          </tr>

          <tr>
            <td class="col-md-2 text-right"><b>Banner</b></td>
            <td>
              <div class="form-group">
                <input name="banner" type="text" value="<?= $result['banner'] ?>"
                       class="form-control input"/>
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
