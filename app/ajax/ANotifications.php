<?php
$sql = 'SELECT id_notification, message
        FROM notifications
        WHERE id_user = :id_user
        AND seen = 0
        AND id_notification NOT IN('.$_GET["notifications"].')
        ORDER BY id_notification DESC
        LIMIT 5';

$query = $DB->prepare($sql);
$query->bindValue(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
$query->execute();

while ($r = $query->fetch())
  $notifications[$r['id_notification']] = $r['message'];

echo json_encode($notifications);
