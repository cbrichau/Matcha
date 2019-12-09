<?php
/* *********************************************************** *\

\* *********************************************************** */

$userMng = new MActions();

// Initialises error state before going through all the checks.
$valid_profile = FALSE;

// Checks requested user is defined and exists.
if (isset($_GET['id_user']) && !empty($_GET['id_user']))
{
	//actualise the visits
	$userMng->I_visit_you($_GET['id_user'],$_SESSION['id_user']);

  $user = $userMng->select_user_by('id_user', $_GET['id_user']);
  if (!is_null($user))
  {
    // Sets profile as valid, and gets the requested user's info.
    $valid_profile = TRUE;
    $interests = $userMng->select_user_interests($user);
    $user->set_interests($interests);
    $user->set_profile_pics();

    // Sets the profile's "user" details for output.
    $user_details['id_user'] = $user->get_id_user();
    $user_details['username'] = $user->get_username();
    $user_details['status'] = ($user->get_last_activity()) ? 'Online' : 'Offline since '.$user->get_last_activity(); ////////change if condition to last_activity < 5 minutes

    // Sets the profile's "I am" details, with labels, for output.
    $i_am['Full name'] = $user->get_first_name().' '.$user->get_last_name();

    if ($user->get_gender() != NULL)
      $i_am['Gender'] = ($user->get_gender() == 'F') ? 'Female' : 'Male';

    if ($user->get_age() != '')
    {
      $s = ($user->get_age() > 1) ? 's' : '';
      $i_am['Age'] = $user->get_age().' year'.$s.' old';
    }

    if ($user->get_location() != '')
      $i_am['Location'] = $user->get_location();

    if ($user->get_bio() != '')
      $i_am['Bio'] = $user->get_bio();

    if ($user->get_interests() != '')
      $i_am['Interests'] = $user->get_interests();

    if ($user->get_popularity_score() != '')
      $i_am['Popularity score'] = $user->get_popularity_score();

    // Sets the profile's "Seeking" details, with labels, for output.
    $seeked['Gender'] = 'Any';
    if ($user->get_seeked_gender() != NULL)
      $seeked['Gender'] = ($user->get_seeked_gender() == 'F') ? 'Female' : 'Male';

    $min = 0;
    $max = 35;
    if ($user->get_seeked_age_range())
    {
      if ($user->get_age() - $user->get_seeked_age_range() > 0)
        $min = $user->get_age() - $user->get_seeked_age_range();
      if ($user->get_age() + $user->get_seeked_age_range() < 35)
        $min = $user->get_age() + $user->get_seeked_age_range();
    }
    $seeked['Age'] = $min.' to '.$max.' years old';

  //select_user_visitors(MUser $user)


  //define the display of like or unlike button same for block and unblock
  $display = [
  'like' => 'style=""',
  'unlike' => 'style="display:none;"',
  'block' => 'style=""',
  'unblock' => 'style="display:none;"',
  ];
  if ($userMng->user_1_liked_user_2($_SESSION['id_user'],$_GET['id_user']) == 1){
  $display['like'] = 'style="display:none;"';
  $display['unlike'] = 'style="display:block;"';
  }
  if ($userMng->user_1_blocked_user_2($_SESSION['id_user'],$_GET['id_user']) == 1){
  $display['block'] = 'style="display:none;"';
  $display['unblock'] = 'style="display:block;"';
  }

    $max = 15;
    if ($user->get_seeked_distance() != '')
      $max = $user->get_seeked_distance();
    $seeked['Distance'] = 'Max '.$max.' km away';

    $seeked['Score range'] = 'Any';
    if ($user->get_seeked_popularity_range() != '')
      $seeked['Score range'] = $user->get_seeked_popularity_range();

    // Defines the profile's "Potential matches" link.
    $potential_matches_link = '';
    if ($user_details['id_user'] == $_SESSION['id_user'])
    {
      $link = Config::ROOT.'index.php';
      $link .= '?cat=search';
      $link .= '&gender=any';
      $link .= '&age_min=1';
      $link .= '&age_max=25';
      $link .= '&distance=8';
      $link .= '&interests=any';
      $link .= '&score_range=160';
      $potential_matches_link = '<a href="'.$link.'" class="btn btn-primary">See potential matches</a>';
    }

    /////////////////////////select_user_visitors(MUser $user)
    /////////////////////////select_user_likers(MUser $user)
  }
}



// Sets the output values and calls the views.
$output->set_head_title('Profile');

require_once(Config::VIEW_HEADER);
if ($valid_profile){
  require_once(Router::$page['view']);
  require_once("js/profile.php");
} else {
  echo '<p>Invalid profile.';
}
require_once(Config::VIEW_FOOTER);
