<?php
/* if(connected) AND ifnot(blocked) do this*/

$actions = new MActions();

if(isset($_POST['id_user_1'],$_POST['id_user_2'])){
	$tabs = $actions->fetch_messages($_POST['id_user_1'],$_POST['id_user_2']);
	$user_2 = $actions->select_user_by('id_user',$_POST['id_user_2']);

	foreach ($tabs as $key => $value) {
		$value['message'] = str_replace(' ', '&nbsp;', $value['message']);
		if($value['id_user_1'] != $_POST['id_user_1']){
		echo '<div class="conversation-item item-left clearfix">';
	} else {
		echo '<div class="conversation-item item-right clearfix">';
	}
		echo '<div class="conversation-user">';
		echo '<img class="user-icon" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="">';
		echo '</div>';
		echo '<div class="conversation-body">';
		if($value['id_user_1'] != $_POST['id_user_1']){
		echo '<div class="name">' . $user_2->get_username() . '</div>';
	} else {
		echo '<div class="name">' . $_SESSION['username'] . '</div>';
	}
		echo '<div class="time hidden-xs">' . $tabs[$key]['message_date'] . ' </div>';
		echo '<div class="text">' . $value['message'] . ' </div>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}
}
?>
