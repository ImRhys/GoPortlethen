<?php

require 'global.php';
$page = new \Page\page();
$page->startSession();

$submitted_username = '';
if (!empty($_POST)) {

  $query = new \Database\Queries\login($db);

  //check if it's an email address
  if (strpos($_POST['username'], '@') === false) {
    $result = $query->quickQuery("SELECT * FROM users WHERE userName = :username", ["username" => $_POST['username']]);
  } else {
    $result = $query->quickQuery("SELECT * FROM users WHERE email = :email", ["email" => $_POST['username']]);
  }

  $loginok = false;
  if ($result) {
    //Set a new pair from the database hash
    $pair = new \Helper\hash();
    $pair->setPair($result['password']);
    $pair->splitHashSalt(); //Split the pair

    //Generate the new hash from the passed password using the salt we just got
    $hash = new \Helper\hash();
    $hash->setPlain($_POST['password']);
    $hash->setSalt($pair->getSalt());
    $hash->genHash();

    //If our hash match we're good to go
    if ($hash->getHash() === $pair->getHash()) {
      $loginok = true;
    }
  }

  if ($loginok) {
    unset($result['password']); //Don't pass our hash into the session
    $_SESSION['user'] = $result;

    header("Location: member.php");
    die("Redirecting to: member.php");

  } else {
    $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
    header("Location: logintest.php?loginfailed=1");
  }
}

if (count($_GET) == 0) {
  $_GET['loginfailed'] = 1;
}

if (isset($_GET['loginfailed'])) {
  $page->setPageTitle("Login");
  $page->setPageDescription("Login Page");

  $page->addCSS("bootstrap.css");
  $page->addCSS("extra.css");

  $page->renderHeader();
  $page->echoHeader();
  ?>

  <div class="container">
    <?php if ($_GET['loginfailed'] == 2) { ?>
      <div class="alert alert-warning">You need to login before accessing this page.</div>
    <?php } else { ?>
      <div class='alert alert-warning'>Login failed please try again.</div>
    <?php } ?>
    <form class="form-horizontal" action="logintest.php" method="post">
      <fieldset>
        <legend>Login</legend>
        <div class="form-group">
          <label class="col-md-4 control-label" for="username">Username / Email</label>

          <div class="col-md-4">
            <input id="username" name="username" type="text" placeholder="e.g jsmith1 or johnsmith@example.com"
                   class="form-control input-md" required="">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-4 control-label" for="password">Password</label>

          <div class="col-md-4">
            <input id="password" name="password" type="password" placeholder="" class="form-control input-md"
                   required="">
          </div>
        </div>
        <div class='form-group'>
          <label class='col-md-4 control-label' for='submit'></label>

          <div class='col-md-8'>
            <button id='submit' type='submit' name='submit' value="Login" class='btn btn-primary'>Submit
            </button>
          </div>
        </div>
      </fieldset>
    </form>
  </div>
  <?php
  $page->addFooterJS("jquery-3.1.1.min.js");
  $page->addFooterJS("bootstrap.min.js");
  $page->renderFooter();
  $page->echoFooter();
} ?>