<?php
if (isset($_POST['id_user_1'],$_POST['id_user_2'],$_POST['action']))
{
	$actions = new MUserMngActions();
	$id_user_1 = $_POST['id_user_1'];
	$id_user_2 = $_POST['id_user_2'];

	switch ($_POST['action'])
	{
		case 'like':
			$actions->action_like($id_user_1, $id_user_2);
			echo 	'<div class="alert alert-success" role="alert">LIKE !</div>';
			break;
		case 'unlike':
			$actions->action_dislike($id_user_1, $id_user_2);
			echo 	'<div class="alert alert-success" role="alert">Dislike !</div>';
			break;
		case 'block':
			$actions->action_block($id_user_1, $id_user_2);
			echo 	'<div class="alert alert-success" role="alert">BLOCK !</div>';
			break;
		case 'report':
			$actions->action_report($id_user_1, $id_user_2);
			echo 	'<div class="alert alert-success" role="alert">REPORT !</div>';
			break;
		case 'unblock':
			$actions->action_unblock($id_user_1, $id_user_2);
			echo 	'<div class="alert alert-success" role="alert">Unblock !</div>';
			break;
	}
}

if (isset($_POST['src'],$_POST['action']))
{
	$target_dir = Config::IMAGES_PATH . "profile_pictures/";
	$result = preg_match('/(\d+)\-\d\.jpg/', $_POST['src'], $matches);
	if ($_POST['action'] == 'change_pic')
	{
		rename($target_dir . $matches['1'] . '-1.jpg', $target_dir . $matches['1'] . '-1.jpg.temp');
		rename($target_dir . $matches['0'], $target_dir . $matches['1'] . '-1.jpg');
		rename($target_dir . $matches['1'] . '-1.jpg.temp', $target_dir . $matches['0']);
	}
	if($_POST['action'] == 'delete_pic')
	{
		unlink($target_dir . $matches['0']);
	}
	echo ('<div class="alert alert-success" role="alert">'. $_POST['src'] .'</div>');
}
