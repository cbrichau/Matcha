<?php
/* *********************************************************** *\
    "Chat conversation" page.
    Connects 2 users and allows them to chat.
\* *********************************************************** */

$userMngActions = new MUserMngActions();
$user_1 = $userMngActions->select_user_by('id_user', $_GET['id_user_1']);
$user_2 = $userMngActions->select_user_by('id_user', $_GET['id_user_2']);

if (is_null($user_1) ||
		is_null($user_2) ||
		!($_SESSION['id_user'] == $user_1->get_id_user() ||
			$_SESSION['id_user'] == $user_2->get_id_user()))
{
  header('Location: '.Config::ROOT.'');
}

// Sets the output values and calls the views.
$output->set_head_title('Chat with '.$user_2->get_username());

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
echo '<script src="'.Config::JS_PATH.'chat.js?'.time().'"></script>';
require_once(Config::VIEW_FOOTER);
