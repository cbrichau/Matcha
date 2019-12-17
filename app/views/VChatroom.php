<h1>My matches</h1>

<?php
foreach ($matches as $matched_user)
{
  echo '<p><a href="'.Config::ROOT.'index.php?cat=chat&id_user1='.$current_user->get_id_user().'&id_user2='.$matched_user->get_id_user().'">'.$matched_user->get_username().'</a></p>';
}
?>
