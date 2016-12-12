<div coccurredontent">
<div class="container pushdown">
  <sectiond id="editprofile">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left">Profile - Edit</h3>

        <div class="pull-right">
          <a href="<?= $page->getFilename() ?>?p=profile">
            <button class="btn btn-default btn-xs">Back</button>
          </a>
          <button id="submit" class="btn btn-default btn-xs">Save</button>
        </div>
      </div>

      <?php
      if (!empty($_POST)) {
        $uquery = new \Database\Queries\user($db);
        $passvar = "";

        if (isset($_POST['password']) && isset($_POST['password2']) && $_POST['password'] !== "" && $_POST['password2'] !== "" && $_POST['password'] == $_POST['password2']) {
          $hash = new \Helper\hash();
          $hash->setPlain($_POST['password']);
          $hash->genSalt();
          $hash->genHash();
          $hash->genPair();
          $passvar = $hash->getPair();
        }

        if (!isset($_POST['fullname'])) {
          die("Missing fullname.");
        }

        if (!isset($_POST['email'])) {
          die("Missing email address.");
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
          die("Invalid E-Mail Address");
        }

        $uquery->checkUsernameAndEmailExists("zxcvbnm", $_POST['email'], $db);

        $arr = [
          ":userID" => $_SESSION['user']['userID'],
          ":displayName" => $_POST['fullname'],
          ":emailAddress" => $_POST['email']
        ];

        if ($passvar !== "") {
          $arr[':password'] = $passvar;
        }

        $uquery->setQuery("
              UPDATE users
              SET
                displayName = :displayName,
                emailAddress = :emailAddress"
          . ($passvar !== "" ? ",\npassword = :password" : "") .
          "\nWHERE
                userID = :userID
            "
        );
        $uquery->setParameters($arr);
        $uquery->runQuery();

        //If query succeeded
        if ($uquery->getResult() > 0) {

          //Update session variables
          $_SESSION['user']['displayName'] = $_POST['fullname'];
          $_SESSION['user']['emailAddress'] = $_POST['email'];

          echo '<div class="alert alert-success">Successfully saved.</div>';
        } else {
          echo '<div class="alert alert-info">Nothing changed.</div>';
        }
      }
      ?>

      <?= $page->startForm($page->getFilename() . "?p=eprofile", "change") ?>
      <table class="table">
        <tr>
          <td class="col-md-2 text-right"><b>Username</b></td>
          <td><?= $_SESSION['user']['userName'] ?></td>
        </tr>
        <tr>
          <td class="col-md-2 text-right"><b>Full Name</b></td>
          <td>
            <div class="form-group">
              <div class="controls">
                <input name="fullname" type="text" value="<?= $_SESSION['user']['displayName'] ?>"
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
                <input name="email" type="text" value="<?= $_SESSION['user']['emailAddress'] ?>"
                       class="form-control input"/>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td class="col-md-2 text-right"><b>Access Level</b></td>
          <td><?= $_SESSION['user']['accessName'] ?></td>
        </tr>
        <tr>
          <td class="col-md-2 text-right"><b>Password</b></td>
          <td>
            <div class="form-group">
              <div class="controls">
                <input name="password" type="password" placeholder="**********" class="form-control input"/>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td class="col-md-2 text-right"><b>Repeat Password</b></td>
          <td>
            <div class="form-group">
              <div class="controls">
                <input name="password2" type="password" placeholder="**********" class="form-control input"/>
              </div>
            </div>
          </td>
        </tr>
      </table>
      <?= $page->endForm() ?>
    </div>
  </sectiond>
</div>
<?php
$page->addFooterRawJS("
  $(document).ready(function() {
      $('#submit').click(function(){
        $('#change').submit()
      })
    })
  ");
?>