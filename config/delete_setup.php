<?php
session_start();
require_once('../app/core/Debugging.php'); // (De)activate debugging by (de)commenting the line.

/* ************************************************** *\
    Connect to mysql
\* ************************************************** */

function connect_db()
{
  require('database.php');
  try
  {
    $DB = new PDO($DB_DSN.';dbname='.$DB_NAME, $DB_USER, $DB_PASSWORD);
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $DB;
  }
  catch (PDOException $e) { return FALSE; }
}

$DB = connect_db();

/* ************************************************** *\
    Delete everything
\* ************************************************** */

if ($DB)
  $DB->exec('DROP DATABASE '.$DB_NAME);

session_destroy();
header('Location: http://localhost:8081/gitmatcha/');
