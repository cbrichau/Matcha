<?php
session_start();

if (!isset($_SESSION['is_logged']))
  $_SESSION['is_logged'] = FALSE;

// (De)activate debugging by (de)commenting the line.
require_once('app/core/Debugging.php');

// Defines all paths as constants and establishes the DB connection.
require_once('app/core/Config.class.php');

// Checks the database is setup.
// Either triggers the setup or continues the process if ok.
if (!isset($_SESSION['is_setup']))
  require_once('app/core/Check_setup.php');
else
{
  // Manages all variables for the header/nav/footer templates.
  require_once('app/core/Output.class.php');
  $output = new Output();

  // Takes the GET and POST arrays to define (and include)
  // the expected models and controller files.
  require_once('app/core/Router.class.php');
  Router::include_mvc_files($_GET, $_POST, $output);
}
