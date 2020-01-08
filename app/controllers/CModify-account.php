<?php
/* *********************************************************** *\
    "Modify my account" page.
    Shows a form to a logged user to modify his/her info.
\* *********************************************************** */

$userMng = new MUserMngModifications();
$current_user = $userMng->select_user_by('id_user', $_SESSION['id_user']);

// Initialises the form's alerts to null,
// and its and prefill values to the user's current info from the DB.
$success_alert = '';
$error_alert = array_fill_keys(array('email', 'username', 'first_name', 'last_name', 'password'), '');
$form_prefill = $userMng->sanitize_for_output($current_user->get_all_properties());

// Processes the modification form.
if (isset($_POST['modify']))
{
  // Overrides the prefill values with the posted ones.
  $form_prefill = array_replace($form_prefill, $_POST);
  $form_prefill = $userMng->sanitize_for_output($form_prefill);

  // Checks the input is valid, or returns an error message.
  $error_msg['email'] = $userMng->check_modify_email($_POST, $current_user);
  $error_msg['username'] = $userMng->check_modify_username($_POST, $current_user);
  $error_msg['first_name'] = $userMng->check_name($_POST, 'first_name');
  $error_msg['last_name'] = $userMng->check_name($_POST, 'last_name');
  $error_msg['password'] = $userMng->check_password($_POST);

  // If the input is not valid (i.e. there's at least one non-false error),
  // sets the corresponding alert(s).
  if (in_array(TRUE, $error_msg))
  {
    foreach ($error_msg as $field => $msg)
    {
      if ($msg == TRUE)
        $error_alert[$field] = '<div class="alert alert-danger"><span>error:</span> '.$msg.'</div>';
    }
  }
  // If all good, modifies the user (updates the user object and the database).
  else
  {
    // if email has changed, resend validation link and logout.
    // else relog to update session.
    $revalidate_email = ($_POST['email'] != $current_user->get_email()) ? TRUE : FALSE;

    $current_user->update_user_info($current_user, $_POST);
    $current_user->encrypt_and_set_password($_POST['pass']);
    if ($revalidate_email)
    {
      $current_user->set_email_confirmed(md5(rand(0,1000)));
      $userMng->update_account($current_user);
      $emailMng = new MEmailMng();
      $emailMng->send_registration_confirmation($current_user);
      $userMng->logout();
      $success_alert = '<div class="alert alert-success"><span>success:</span> An email has been sent to you with a validation link.</div>';
    }
    else
    {
      $userMng->update_account($current_user);
      $userMng->login($current_user->get_username());
      $success_alert = '<div class="alert alert-success"><span>success:</span> Your account has been modified</div>';
    }
  }
}

// Sets the output values and calls the views.
$output->set_head_title('Modify my account');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
require_once(Config::VIEW_FOOTER);
