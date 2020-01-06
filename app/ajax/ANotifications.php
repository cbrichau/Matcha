<?php
/* ----------------------------- *\
    GET UNSEEN NOTIFICATIONS
    Also deletes seen ones
\* ----------------------------- */

if ($_GET['notifications'] == 'get' &&
    isset($_GET['ids']) &&
    preg_match('/^(\d+)(,\d+)*$/', $_GET['ids']))
{
  $sql = 'SELECT id_notification, message
          FROM notifications
          WHERE id_user = :id_user
          AND seen = 0
          AND id_notification NOT IN('.$_GET["ids"].')
          ORDER BY id_notification DESC
          LIMIT 10';
  $query = $DB->prepare($sql);
  $query->bindValue(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
  $query->execute();

  while ($r = $query->fetch())
    $notifications[$r['id_notification']] = $r['message'];

  echo json_encode($notifications);

  $sql = 'DELETE FROM notifications
          WHERE seen = 1';
  $query = $DB->prepare($sql);
  $query->execute();
}

/* ----------------------------- *\
    UPDATE SEEN NOTIFICATIONS
\* ----------------------------- */

elseif ($_GET['notifications'] == 'seen' &&
        isset($_GET['id']) &&
        $_GET['id'] == filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT) &&
        $_GET['id'] == filter_var($_GET['id'], FILTER_VALIDATE_INT))
{
  $sql = 'UPDATE notifications
          SET seen = 1
          WHERE id_notification = :id';

  $query = $DB->prepare($sql);
  $query->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
  $query->execute();
}

/* ----------------------------- *\
    BAD INPUT REDIRECT
\* ----------------------------- */

else
  header('Location: '.Config::ROOT.'');
