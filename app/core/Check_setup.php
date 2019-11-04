<?php
$db_exists = Config::get_db();

if ($db_exists === FALSE)
   echo 'You must <a href="'.Config::ROOT.'config/setup.php">setup the database</a> first.';
else
{
  $_SESSION['is_setup'] = TRUE;
  header('Location: '.Config::ROOT.'');
}
?>
