<?php
/* *********************************************************** *\
		Profile page (own or other's)
		Shows all the user's info,
		the ideal partner's info,
		the like/block/report actions,
\* *********************************************************** */

$userMng = new MUserMngActions();

// Initialises error state before going through all the checks.
$valid_profile = FALSE;

// Checks requested user is defined and exists.
if (isset($_GET['id_user']) && !empty($_GET['id_user']))
{
  $user = $userMng->select_user_by('id_user', $_GET['id_user']);
  if (!is_null($user))
  {
    // Sets profile as valid and marks the profile visit.
    $valid_profile = TRUE;
    $userMng->I_visit_you($_GET['id_user'], $_SESSION['id_user']);

    // Gets the requested user's info
    // and sets the profile's basic user details for output.
    $interests = $userMng->select_user_interests($user);
    $user->set_interests($interests);
    $user->set_profile_pics();

    $user_details['id_user'] = $user->get_id_user();
    $user_details['username'] = $user->get_username();
    $user_details['status'] = ($user->get_last_activity()) ? 'Online' : 'Offline since '.$user->get_last_activity();
    /////////////////change if condition to last_activity < 5 minutes

		// Defines the display of like or unlike button same for block and unblock.
		$display = [
			'block' => 'style=""',
			'unblock' => 'style="display:none;"',
			'like' => 'style=""',
			'unlike' => 'style="display:none;"'
		];
		if ($userMng->user_1_blocked_user_2($_SESSION['id_user'],$_GET['id_user']) == 1)
		{
			$display['block'] = 'style="display:none;"';
			$display['unblock'] = 'style="display:block;"';
		}
		if ($userMng->user_1_liked_user_2($_SESSION['id_user'],$_GET['id_user']) == 1)
		{
			$display['like'] = 'style="display:none;"';
			$display['unlike'] = 'style="display:block;"';
		}

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
      $i_am['Popularity score'] = $user->get_popularity_score().' points';

    // Sets the profile's "Seeking" details, with labels, for output.
		// Along with the search URL parameters.
		$seeking['Gender'] = 'Any';
    $gender = 'any';
    if ($user->get_seeked_gender() != NULL)
		{
			$seeking['Gender'] = ($user->get_seeked_gender() == 'F') ? 'Female' : 'Male';
			$gender = $user->get_seeked_gender();
		}

    $min_age = ($user->get_seeked_age_min() != '') ? $user->get_seeked_age_min() : 1;
    $max_age = ($user->get_seeked_age_max() != '') ? $user->get_seeked_age_max() : 25;
    $seeking['Age'] = $min_age.' to '.$max_age.' years old';

    $max_distance = ($user->get_seeked_distance() != '') ? $user->get_seeked_distance() : 8;
    $seeking['Location'] = 'Max '.$max_distance.' km away';

    $seeking['Interests'] = 'Any';
    $interests = 'any';
    if ($user->get_seeked_interests() != '')
    {
      $seeking['Interests'] = $user->get_interests();
      $interests = $user->get_interests();
    }

    $popularity_range = ($user->get_seeked_popularity_range() != '') ? $user->get_seeked_popularity_range() : 500;
    $min_popularity = $user->get_popularity_score() - $popularity_range;
    $max_popularity = $user->get_popularity_score() + $popularity_range;
    $seeking['Popularity'] = $min_popularity.' to '.$max_popularity.' points';

    // Defines the profile's "Potential matches" link.
    $potential_matches_link = '';
    if ($user_details['id_user'] == $_SESSION['id_user'])
    {
      $link = Config::ROOT.'index.php';
      $link .= '?cat=search';
      $link .= '&gender='.$gender;
      $link .= '&age_min='.$min_age;
      $link .= '&age_max='.$max_age;
      $link .= '&distance='.$max_distance;
      $link .= '&interests=any';
      $link .= '&popularity_range='.$popularity_range;
      $potential_matches_link = '<a href="'.$link.'" class="btn btn-primary">See potential matches</a>';
    }

		// Gets the list of the user's visitors and likers.
  	$user_visitors = $userMng->who_visits_me($_GET['id_user']);
    $user_likers = $userMng->who_like_me($_GET['id_user']);
  }
	//Upload pictures


	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$uploadOk = 1;
		$uploadOkbis = 1;
		$target_dir = Config::IMAGES_PATH . "profile_pictures/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		for ($i=1; $i <= 5; $i++) {
			if(!(file_exists($target_dir . $_GET['id_user'] . '-' . $i . ".jpg"))){
				$target_file = $target_dir . $_GET['id_user'] . '-' . $i . ".jpg";
				break;
			} elseif ($i == 5){
				$error = "You have already 5 pictures.";
				$uploadOkbis = 0;
			}
		}
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if(!isset($error)){
			if($check !== false) {
			    $error = "File is an image - " . $check["mime"] . ".";
			    $uploadOk = 1;
			} else {
			    $error = "File is not an image.";
			    $uploadOk = 0;
			}
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
		    $error = "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg") {
		    $error = "Sorry, only JPG files are allowed.";
		    $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0 || $uploadOkbis == 0) {
			$error .= " Your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			$error = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			}
		}
	}
}



// Sets the output values and calls the views.
$output->set_head_title('Profile');

require_once(Config::VIEW_HEADER);
if ($valid_profile){
  require_once(Router::$page['view']);
<<<<<<< HEAD
  require_once(Config::JS_PATH.'profile.php');
=======
  require_once(Config::JS_PATH . "profile.php");
>>>>>>> e992021145b073eb5e0fafa0d2e68b38d5487c30
} else {
  echo '<p>Invalid profile.';
}
require_once(Config::VIEW_FOOTER);
