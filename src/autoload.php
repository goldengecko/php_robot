<?php

/**
 * Simple autoload to help out with testing. No need to do any
 * special processing for namespaces since this is a simple app
 * without any namespaces.
 */
spl_autoload_register(function ($name) {
  if (file_exists("src/$name.php")) {
    require_once "src/$name.php";
    return true;
  }
  return false;
});