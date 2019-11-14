<?php
session_start();
require_once('../app/core/Debugging.php'); // (De)activate debugging by (de)commenting the line.
require_once('database.php');

/* ************************************************** *\
    Connect to mysql and delete everything
\* ************************************************** */

try
{
  $DB = new PDO($DB_DSN.';dbname='.$DB_NAME, $DB_USER, $DB_PASSWORD);
  $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
  die("Couldn't connect");
}

if ($DB)
  $DB->exec('DROP DATABASE '.$DB_NAME);

session_destroy();
header('Location: http://localhost:8081/gitmatcha/');
