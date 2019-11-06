<?php
/* *********************************************************** *\
    "Chat room" page.
    ...
\* *********************************************************** */

// (De)activate debugging by (de)commenting the line.
//require_once('app/core/Debugging.php');
$chat = new MChat();

if(isset($_POST['sender']) && isset($_POST['receiver']) && isset($_POST['message']))
		$chat->send_message($_POST['sender'],$_POST['receiver'],$_POST['message']);



// Sets the output values and calls the views.
$output->set_head_title('Chat room');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
require_once(Config::VIEW_FOOTER);
//require_once(Config::JS_PATH . "test.js");
?>

<script type="text/babel" src="<?=Config::JS_PATH?>test.js"></script>
