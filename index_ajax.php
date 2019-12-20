<?php
session_start();

// (De)activate debugging by (de)commenting the line.
//require_once('app/core/Debugging.php');

// Defines all paths as constants and establishes the DB connection.
require_once('app/core/Config.class.php');

// Includes necessary models.
spl_autoload_register(function($className)
{
  require_once(Config::MODELS_PATH.$className.'.class.php');
});

// Create DB connnection.
$DB = Config::get_db();

// Router:
if (isset($_GET['notifications']))
  require_once(Config::AJAX_PATH.'ANotifications.php');
else if (isset($_GET['chat']))
  require_once(Config::AJAX_PATH.'AChat.php');
else
  header('Location: '.Config::ROOT.'');
