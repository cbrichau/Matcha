<?php
/* *********************************************************** *\

\* *********************************************************** */

$userMng = new MUserMng();

// Initialises error state before going through all the checks.
$valid_profile = FALSE;

// Checks requested user is defined and exists.
if (isset($_GET['id_user']) && !empty($_GET['id_user']))
{
  $user = $userMng->select_user_by('id_user', $_GET['id_user']);
  if (!is_null($user))
  {
    // Sets profile as valid, and gets the requested user's info.
    $valid_profile = TRUE;
    $interests = $userMng->select_user_interests($user);
    $user->set_interests($interests);

    // Sets the profile's array(label => value) for output
    $user_details['id_user'] = $user->get_id_user();
    $user_details['username'] = $user->get_username();
    $user_details['status'] = ($user->get_last_activity()) ? 'Online' : 'Offline since '.$user->get_last_activity(); ////////change if condition to last_activity < 5 minutes

    $user_details_labeled['Full name'] = $user->get_first_name().' '.$user->get_last_name();

    if ($user->get_gender_self() != NULL)
      $user_details_labeled['Gender'] = ($user->get_gender_self() == 'F') ? 'Female' : 'Male';

    if ($user->get_age() != '')
    {
      $s = ($user->get_age() > 1) ? 's' : '';
      $user_details_labeled['Age'] = $user->get_age().' year'.$s.' old';
    }

    if ($user->get_location() != '')
      $user_details_labeled['Location'] = $user->get_location();

    if ($user->get_bio() != '')
      $user_details_labeled['Bio'] = $user->get_bio();

    // if ($user->get_interests() != '')
    //   $user_details_labeled['Interests'] = $user->get_interests();
  }

  //select_user_visitors(MUser $user)
}

// Sets the output values and calls the views.
$output->set_head_title('Profile');

require_once(Config::VIEW_HEADER);
if ($valid_profile)
  require_once(Router::$page['view']);
else
  echo '<p>Invalid profile.';
require_once(Config::VIEW_FOOTER);
