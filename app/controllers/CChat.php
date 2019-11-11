<?php
/* *********************************************************** *\
    "Chat room" page.
    ...
\* *********************************************************** */


$chat = new MChat();

if(isset($_POST['sender']) && isset($_POST['receiver']) && isset($_POST['message'])){
	$message =  trim($_POST['message']);
	if(!empty($message) /*&& strlen($message) <= 65,535*/)
		$chat->send_message($_POST['sender'],$_POST['receiver'],$message);
	}

if(isset($_SESSION['username'])){
	$sender = $chat->select_user_by('username',$_SESSION['username']);
}
if(isset($_POST['receiver'])){
	$receiver = $chat->select_user_by('id_user',$_POST['receiver']); //change into $_POST['receiver']
}



// Sets the output values and calls the views.
$output->set_head_title('Chat room');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
require_once(Config::VIEW_FOOTER);
require_once(Config::JS_PATH . "chat.php");
?>
