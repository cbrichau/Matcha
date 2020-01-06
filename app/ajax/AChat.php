<?php
$userMngActions = new MUserMngActions();

/* ----------------------------- *\
    GET MESSAGES
\* ----------------------------- */

if ($_GET['chat'] == 'get_messages' &&
    isset($_GET['id_user_1']) &&
    isset($_GET['id_user_2']) &&
    isset($_GET['id_last_message']))
{
	$messages = $userMngActions->fetch_messages($_GET['id_user_1'], $_GET['id_user_2'], $_GET['id_last_message']);
  echo json_encode($messages);
}

/* ----------------------------- *\
    SEND MESSAGE
\* ----------------------------- */

if ($_GET['chat'] == 'send_message')
{
  if (isset($_POST['sender']) &&
  		isset($_POST['receiver']) &&
  		isset($_POST['message']))
  {
  	$message = trim($_POST['message']);
  	if (!empty($message) /*&& strlen($message) <= 65,535*/)
  		$userMngActions->send_message($_POST['sender'],$_POST['receiver'],$message);
  }
/*
  if (isset($_SESSION['username']))
  {
  	$sender = $userMngActions->select_user_by('username',$_SESSION['username']);
  }

  if (isset($_POST['receiver']))
  {
  	$receiver = $userMngActions->select_user_by('id_user',$_POST['receiver']); //change into $_POST['receiver']
  }*/
}
