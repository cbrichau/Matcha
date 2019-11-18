<?php
session_start();
//require_once('app/core/Debugging.php');
require_once('app/core/Config.class.php');

$DB = Config::get_db();

if (isset($_GET['notifications']))
{
  $sql = 'SELECT id_notification, message
          FROM notifications
          WHERE id_user = :id_user
          AND seen = 0
          ORDER BY id_notification DESC
          LIMIT 5';

  $query = $DB->prepare($sql);
  $query->bindValue(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
  $query->execute();

  $i = 0;
  while ($r = $query->fetch())
  {
    $notifications[$r['id_notification']] = $r['message'];
    $i++;
  }
  $notifications['count'] = $i;

  echo json_encode($notifications);
}
