<?php

require "global.php";

$page->startSession();

session_unset();
session_destroy();

header("Location: index.php");
die("logged out.");