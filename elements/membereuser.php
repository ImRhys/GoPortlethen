<?php

$access = new \Database\Queries\accesslevel($db);
$access->runQuery();
?>
<div id="content">
  <div class="container pushdown">

    <?php if ($access->getAccessLevelIDByName($_SESSION['user']['accessName']) > 8) { ?>

      <sectiond id="edituser">
        <div class="panel panel-default">
          <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left">Users Manager - Edit User</h3>

            <div class="pull-right">
              <button id="back" class="btn btn-default btn-xs">Back</button>
              <button id="submit" class="btn btn-default btn-xs">Save</button>
            </div>
          </div>

          <?php

          $uquery = new \Database\query($db);
          $uquery->setQuery("SELECT * FROM users WHERE userID = :userID LIMIT 1");
          $uquery->setParameters([":userID" => $_GET['u']]);
          $uquery->runQuery();
          $result = $uquery->getResult();

          //If we get nothing back something has gone wrong somewhere
          if (empty($result)) {
            die("An error has occurred.");
          }

          //Swtich our result into the first array returned, makes life a little easier
          $result = $result[0];

          if (!empty($_POST)) {
            $updquery = new \Database\Queries\user($db);

            if (!isset($_POST['userName'])) {
              die("Missing username.");
            }

            if (!isset($_POST['displayName'])) {
              die("Missing fullname.");
            }

            if (!isset($_POST['emailAddress'])) {
              die("Missing email address.");
            }

            if (!filter_var($_POST['emailAddress'], FILTER_VALIDATE_EMAIL)) {
              die("Invalid E-Mail Address");
            }

            if (!isset($_POST['accessLevel'])) {
              die("Missing accesslevel.");
            }

            if ($_POST['emailAddress'] !== $result['emailAddress']) {
              $updquery->checkEmailExists($_POST['emailAddress'], $db);
            }
			
			if ($_POST['displayName'] !== $result['displayName']) {
		      $updquery->checkUsernameExists($_POST['displayName'], $db);
			}

            $arr = [
              ":userID" => intval($_GET['u']),
              ":userName" => $_POST['userName'],
              ":displayName" => $_POST['displayName'],
              ":emailAddress" => $_POST['emailAddress'],
              ":accessLevel" => intval($_POST['accessLevel'])
            ];

            $updquery->setQuery("
              UPDATE users
              SET
                userName = :userName,
                displayName = :displayName,
                emailAddress = :emailAddress,
                accessLevel = :accessLevel
              WHERE
                userID = :userID
            "
            );

            $updquery->setParameters($arr);
            $updquery->runQuery();

            //If query succeeded
            if ($updquery->getResult() > 0) {
              echo '<div class="alert alert-success">Successfully saved.</div>';

              //Rerun query to update page info after change
              $uquery->runQuery();
              $result = $uquery->getResult();
              $result = $result[0];
            } else {
              echo '<div class="alert alert-info">Nothing changed.</div>';
            }
          }
          ?>

          <?= $page->startForm($page->getFilename() . "?p=euser&u=" . $_GET['u'], "change") ?>
          <table class="table">
            <tr>
              <td class="col-md-2 text-right"><b>Username</b></td>
              <td>
                <div class="controls">
                  <input name="userName" type="text" value="<?= $result['userName'] ?>"
                         class="form-control input"/>
                </div>
              </td>
            </tr>
            <tr>
              <td class="col-md-2 text-right"><b>Full Name</b></td>
              <td>
                <div class="form-group">
                  <div class="controls">
                    <input name="displayName" type="text" value="<?= $result['displayName'] ?>"
                           class="form-control input"/>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td class="col-md-2 text-right"><b>Email Address</b></td>
              <td>
                <div class="form-group">
                  <div class="controls">
                    <input name="emailAddress" type="text" value="<?= $result['emailAddress'] ?>"
                           class="form-control input"/>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td class="col-md-2 text-right"><b>Access Level</b></td>
              <td>
                <div class="form-group">
                  <select name="accessLevel" class="form-control scrollable-dropdown">
                    <?= $access->generateAccessListOptions($result['accessLevel']) ?>
                  </select>
                </div>
              </td>
            </tr>
          </table>
          <?= $page->endForm() ?>
        </div>
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

