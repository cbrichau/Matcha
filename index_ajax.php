<?php
session_start();
require_once('app/core/Config.class.php');

$DB = Config::get_db();

if (isset($_GET['notifications']))
  require_once(Config::AJAX_PATH.'ANotifications.php');
else
  header('Location: '.Config::ROOT.'');
