<?php
/* *********************************************************** *\
    "Profile" (own an others) page.
    ...
\* *********************************************************** */

$error = TRUE;

if (isset($_GET['id_user']) &&
    !empty($_GET['id_user']))
{
  $userMng = new MUserMng();
  $user = $userMng->select_user_by('id_user', $_GET['id_user']);
  if (!is_null($user))
  {
    $error = FALSE;
    $interests = $userMng->select_user_interests($user);
    $user->set_interests($interests);
    $user_values = $user->get_all_properties();
  }
}

// Sets the output values and calls the views.
$output->set_head_title('Profile');

require_once(Config::VIEW_HEADER);
if (!$error)
  require_once(Router::$page['view']);
else
  echo '<p>Invalid profile.';
require_once(Config::VIEW_FOOTER);
