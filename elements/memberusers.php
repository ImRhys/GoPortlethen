<?php

$access = new \Database\Queries\accesslevel($db);
$access->runQuery();
?>
<div id="content">
  <div class="container pushdown">

    <?php if ($access->getAccessLevelIDByName($_SESSION['user']['accessName']) > 8) { ?>

      <?php

      $uquery = new \Database\query($db);
      $uquery->setQuery("SELECT * FROM users ORDER BY accessLevel DESC, userName ASC");
      $uquery->runQuery();
      $result = $uquery->getResult();

      ?>
      <sectiond id="users">
        <div class="panel panel-default">
          <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left">Users Manager</h3>
          </div>
        </div>
        <table class="table">
          <thead>
          <th></th>
          <th>Username</th>
          <th>Email Address</th>
          <th>Fullname</th>
          <th>Access Level</th>
          </thead>
          <?php foreach ($result as $user) { ?>
            <tr>
              <td><a href="<?= $page->getFilename() ?>?p=euser&u=<?= $user['userID'] ?>">
                  <button class="btn btn-default btn-xs">Edit</button>
                </a></td>
              <td><?= $user['userName'] ?></td>
              <td><?= $user['emailAddress'] ?></td>
              <td><?= $user['displayName'] ?></td>
              <td><?= $access->getAccessLevelNameByID($user['accessLevel']) ?></td>
            </tr>
          <?php } ?>
        </table>
      </sectiond>

    <?php } else { ?>
      <div class="alert alert-warning">You do not have access to this page.</div>
    <?php } ?>
  </div>
</div>


