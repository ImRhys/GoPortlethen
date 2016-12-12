<?php

$access = new \Database\Queries\accesslevel($db);
$access->runQuery();
?>
<div id="content">
  <div class="container pushdown">

    <?php if ($access->getAccessLevelIDByName($_SESSION['user']['accessName']) > 8) { ?>

      <sectiond id="editnews">
        <div class="panel panel-default">
          <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left">Add News</h3>

            <div class="pull-right">
              <button id="back" class="btn btn-default btn-xs">Back</button>
              <button id="submit" class="btn btn-default btn-xs">Save</button>
            </div>
          </div>

          <?php

          if (!empty($_POST)) {

            if (!isset($_POST['title'])) {
              die("Missing news title.");
            }

            if (!isset($_POST['content'])) {
              die("Missing content.");
            }

            $updquery = new \Database\Queries\clube($db);

            $arr = [
              ":title" => $_POST['title'],
              ":content" => $_POST['content'],
            ];

            $updquery->setQuery("
              INSERT INTO health_news
              (
                title,
                content
              )
              VALUES
              (
                :title,
                :content
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

          <?= $page->startForm($page->getFilename() . "?p=addnews", "change") ?>
          <table class="table">
            <tr>
              <td class="col-md-2 text-right"><b>Title</b></td>
              <td>
                <div class="controls">
                  <input name="title" type="text" class="form-control input"/>
                </div>
              </td>
            </tr>

            <tr>
              <td class="col-md-2 text-right"><b>Content</b></td>
              <td>
                <div class="form-group">
                  <div class="controls">
                    <input name="content" type="text" class="form-control input"/>
                  </div>
                </div>
              </td>
            </tr>
            <?= $page->endForm() ?>
          </table>

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