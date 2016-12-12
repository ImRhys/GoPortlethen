<?php

require 'global.php';

$page = new \Page\page();
$page->startSession();
$page->setPageTitle("Register");
$page->setPageDescription("Register");

$query = new \Database\Queries\login($db);

if ($page->isLogin()) {
  header("Location: member.php");
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
  if (empty($_POST['password2'])) {
    die("Please repeat your password.");
  }
  if ($_POST['password'] !== $_POST['password2']) {
    die("Passwords don't match.");
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

  header("Location: login.php?registered=1");
  die("Registered");
}

$page->addHeaderHTML('<meta charset="utf-8"/>');
$page->addHeaderHTML('<meta name="viewport" content="width=device-width, initial-scale=1"/>');
$page->setPageTitle(\Config\Config::get("sitename") . ' - Register');
$page->setPageDescription($page->getPageTitle());


//Fonts
$page->addCSS("https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css", false);

//Style
$page->addCSS("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css", false);
$page->addCSS("main.css");
$page->addCSS("orange.css");
$page->addCSS("extra.css");

$page->renderHeader();
$page->echoHeader();
?>

  <!-- Navigation include -->
<?php include 'header.php'; ?>

  <div id="content">
    <section id="register">
      <div class="container">
        <div class="row">
          <div
            class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 md-margin-top">
            <div class="page-subheader text-center">
              <h1>Register</h1>
              <hr/>
              <p>Register as a member to create and contribute to clubs and maps!</p>
            </div>

            <form action="#" method="post">

              <div class="form-group">
                <div class="controls">
                  <input name="fullname" type="text" placeholder="Full Name" class="form-control input"/>
                </div>
              </div>

              <div class="form-group">
                <div class="controls">
                  <input name="username" type="text" placeholder="Username" class="form-control input"/>
                </div>
              </div>

              <div class="form-group">
                <div class="controls">
                  <input name="email" type="text" placeholder="Email" class="form-control input"/>
                </div>
              </div>

              <div class="form-group">
                <div class="controls">
                  <input name="password" type="password" placeholder="Password" class="form-control input"/>
                </div>
              </div>

              <div class="form-group">
                <div class="controls">
                  <input name="password2" type="password" placeholder="Repeat password" class="form-control input"/>
                </div>
              </div>

              <div class="form-group">
                <div class="controls">
                  <div class="checkbox">
                    <input name="checkbox" id="checkbox1" value="checkbox1" checked="" type="checkbox">
                    <label for="checkbox1">
                      I agree and have read <a href="#">terms and conditions</a>.
                    </label>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <button name="submit" class="btn btn-block btn-primary">Sign up</button>
              </div>
            </form>
          </div>
        </div>
        <!-- Row / END -->
      </div>
      <!-- Container / END -->
    </section>
  </div><!-- Content / END -->


  <!-- Footer / START -->
  <footer class="footer">
    <div class="container">
      <span class="copyright">
        Copyright <?= \Config\Config::get("copyrightyear") ?>. All rights served.
      </span>

      <span class="links">
        <a href="#">Terms of service</a>
        <a href="#">Privacy policy</a>
      </span>
    </div>
  </footer><!-- Footer / END -->

<?php
$page->addFooterJSifIE9("https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js", false);
$page->addFooterJSifIE9("https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js", false);
$page->addFooterJS("https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js", false);
$page->addFooterJS("main.js");
$page->addFooterJS("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js", false);
$page->renderFooter();
$page->echoFooter();
?>