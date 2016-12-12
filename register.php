<?php

require 'global.php';

$page = new \Page\page();
$page->startSession();
$page->setPageTitle("Register");
$page->setPageDescription("Register");

$query = new \Database\Queries\login($db);

if (isset($_SESSION['user'])) {
  die("Already logged in.");
}

if (!empty($_POST)) {
  // Ensure that the user fills out fields
  if (empty($_POST['username'])) {
    die("Please enter a username.");
  }
  if (empty($_POST['password'])) {
    die("Please enter a password.");
  }
  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    die("Invalid E-Mail Address");
  }
  if (empty($_POST['fullname'])) {
    die("Please enter your fullname.");
  }

  //Check if the username is already taken
  $result = $query->quickQuery("SELECT 1 FROM users WHERE username = :username", [":username" => $_POST['username']]);

  //Die if it is
  if ($result) {
    die("This username is already in use");
  }
  //Check if email is already taken
  $result = $query->quickQuery("SELECT 1 FROM users WHERE emailAddress = :email", [":email" => $_POST['email']]);

  //Die if it is
  if ($result) {
    die("This email address is already registered");
  }

  //Add row to database
  $query = new \Database\Queries\register($db);
  $query->setQuery("
            INSERT INTO users (
                userName,
                password,
                emailAddress,
                displayName,
                accessLevel
            ) VALUES (
                :userName,
                :password,
                :emailAddress,
                :displayName,
                :accessLevel
            )
        ");

  $hash = new \Helper\hash();
  $hash->setPlain($_POST['password']);
  $hash->getSalt();
  $hash->genHash();
  $hash->genPair();

  $query->setParameters([
    ":userName" => $_POST['username'],
    ":password" => $hash->getPair(),
    ":emailAddress" => $_POST['email'],
    ":displayName" => $_POST['fullname'],
    ":accessLevel" => 0
  ]);

  $query->runQuery();

  //header("Location: index.php?registered=1");
  die("Registered");
}

$page->addCSS("bootstrap.css");
$page->addCSS("extra.css");

$page->renderHeader();
$page->echoHeader();
?>
  <form class="form-horizontal" action="register.php" method="post">
    <fieldset>
      <legend>Register</legend>
      <div class='form-group'>
        <label class='col-md-4 control-label' for='name'>Full Name</label>

        <div class='col-md-5'>
          <input id='fullname' name='fullname' type='text' placeholder='e.g John Smith' class='form-control input-md'
                 required=''>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-4 control-label" for="username">Username</label>

        <div class="col-md-4">
          <input id="username" name="username" type="text" placeholder="e.g jsmith1" class="form-control input-md"
                 required="">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-4 control-label" for="email">Email</label>

        <div class="col-md-4">
          <input id="email" name="email" type="text" placeholder="e.g johnsmith@example.com"
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
          <button id='submit' name='submit' class='btn btn-primary'>Submit</button>
        </div>
      </div>
    </fieldset>
  </form>
<?php
$page->addFooterJS("jquery-3.1.1.min.js");
$page->addFooterJS("bootstrap.min.js");
$page->renderFooter();
$page->echoFooter();
?>