<?php

$access = new \Database\Queries\accesslevel($db);
$access->runQuery();
?>
<div id="content">
  <div class="container pushdown">

    <?php if ($access->getAccessLevelIDByName($_SESSION['user']['accessName']) > 8) { ?>

      <?php
      $cquery = new \Database\Queries\clubs($db);
      $cquery->easyRun();
      ?>

      <sectiond id="club">
        <div class="panel panel-default">
          <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left">Clubs Manager</h3>
          </div>
        </div>
        <table class="table">
          <thead>
          <th></th>
          <th>Club Name</th>
          <th>Description</th>
          <th>Admin</th>
          <th>Genre</th>
          <th>Banner</th>
          </thead>
          <?php
          foreach ($cquery->getResult() as $val) { ?>
            <tr>
              <td class="col-md-1">
                <a href="<?= $page->getFilename() ?>?p=eclubs&c=<?= $val['clubID'] ?>">
                  <button class="btn btn-default btn-xs">Edit</button>
                </a>
              </td>
              <td class="col-md-2"><?= $val['clubName'] ?></td>
              <td class="col-md-3"><?= $val['description'] ?></td>
              <td class="col-md-2">
                <?php
                $qq = new \Database\query($db);
                $qq->quickQuery("SELECT userName FROM users WHERE userID = :userID", [":userID" => $val['adminID']]);
                echo $qq->getResult()[0]["userName"];
                ?>
              </td>
              <td class="col-md-2">
                <?php
                $qq = new \Database\Queries\genre($db);
                $qq->runQuery();
                echo $qq->getGenreNameByID($val['genreID']);
                ?>
              </td>
              <td class="col-md-2"><?= $val['banner'] ?></td>
            </tr>
          <?php } ?>
        </table>
      </sectiond>

    <?php } else { ?>
      <div class="alert alert-warning">You do not have access to this page.</div>
    <?php } ?>
  </div>
</div>
