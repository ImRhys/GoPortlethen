<?php if ($p === "profile") { ?>
  <div class="content">
    <div class="container pushdown">
      <sectiond id="profile">
        <div class="panel panel-default">
          <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left">Profile Summary</h3>
            <a href="<?= $page->getFilename() ?>?p=eprofile" class="pull-right">
              <button class="btn btn-default btn-xs">Edit</button>
            </a>
          </div>
          <table class="table">
            <tr>
              <td class="col-md-2 text-right"><b>Username</b></td>
              <td><?= $_SESSION['user']['userName'] ?></td>
            </tr>
            <tr>
              <td class="col-md-2 text-right"><b>Full Name</b></td>
              <td><?= $_SESSION['user']['displayName'] ?></td>
            </tr>
            <tr>
              <td class="col-md-2 text-right"><b>Email Address</b></td>
              <td><?= $_SESSION['user']['emailAddress'] ?></td>
            </tr>
            <tr>
              <td class="col-md-2 text-right"><b>Access Level</b></td>
              <td><?= $_SESSION['user']['accessName'] ?></td>
            </tr>
          </table>
        </div>
      </sectiond>
    </div>
  </div>
<?php } ?>