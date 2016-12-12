<?php

require 'global.php';
$page = new \Page\page();
$page->startSession();

$submitted_username = '';
if (!empty($_POST)) {

  $query = new \Database\Queries\login($db);

  //check if it's an email address
  if (strpos($_POST['username'], '@') === false) {
    $result = $query->quickQuery("SELECT * FROM users WHERE userName = :username", [":username" => $_POST['username']]);
  } else {
    $result = $query->quickQuery("SELECT * FROM users WHERE email = :email", [":email" => $_POST['username']]);
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
    header("Location: login.php?loginfailed=2");
  }
}

if (count($_GET) == 0) {
  $_GET['loginfailed'] = 0;
}

if (isset($_GET['loginfailed'])) {
  $page->setPageTitle("Login");
  $page->setPageDescription("Login Page");

  $page->addHeaderHTML('<meta charset="utf-8"/>');
  $page->addHeaderHTML('<meta name="viewport" content="width=device-width, initial-scale=1"/>');
  $page->setPageTitle(\Config\Config::get("sitename") . ' - Login');
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
    <section id="login">
      <div class="container">
        <div class="row">
          <div
            class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 md-margin-top">
            <div class="page-subheader text-center">
              <h1>Sign in</h1>
              <hr/>
              <p>If you are not already a member, <a href="register.php">please sign up</a></p>
            </div>

            <?php if ($_GET['loginfailed'] == 1) { ?>
              <div class="alert alert-warning">You need to login before accessing this page.</div>
            <?php } elseif ($_GET['loginfailed'] > 1) { ?>
              <div class='alert alert-warning'>Login failed please try again.</div>
            <?php } ?>

            <?php if ($_GET['registered'] == 1) { ?>
              <div class='alert alert-success'>Thank you for registering, please login.</div>
            <?php } ?>


            <form action="login.php" method="post">
              <fieldset>
                <div class="form-group">
                  <div class="controls">
                    <input name="username" id="username" type="text" placeholder="Username / Email Address"
                           class="form-control input"/>
                  </div>
                </div>

                <div class="form-group">
                  <div class="controls">
                    <input name="password" id="password" type="password" placeholder="Password"
                           class="form-control input"/>
                  </div>
                </div>

                <div class="form-group">
                  <div class="controls">
                    <div class="checkbox">
                      <input name="checkbox" id="checkbox1" value="checkbox1" checked="" type="checkbox">
                      <label for="checkbox1">
                        Remember me
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-group">

                  <button class="btn btn-primary">Enter</button>
                  <a href="#" class="sm-margin-top pull-right">Forgot your password?</a>
                </div>
              </fieldset>
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
} ?>