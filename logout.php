<?php

require "global.php";

$page->startSession();

session_unset();
session_destroy();

die("logged out.");