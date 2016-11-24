<?php

function my_autoloader($class) {
    $class = str_replace('\\', '/', $class);
    require 'resources' . DIRECTORY_SEPARATOR . $class . '.class.php';
}

spl_autoload_register('my_autoloader');