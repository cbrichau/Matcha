<?php
	if(isset($_POST['id_user_1'],$_POST['id_user_2'],$_POST['action'])){
		$actions = new MActions();
		$id_user_1 = $_POST['id_user_1'];
		$id_user_2 = $_POST['id_user_2'];


		switch ($_POST['action']){
			case 'like':
				$actions->action_like($id_user_1, $id_user_2);
				echo 	'<div class="alert alert-success" role="alert">LIKE !</div>';
				break;
			case 'block':
				$actions->action_block($id_user_1, $id_user_2);
				echo 	'<div class="alert alert-success" role="alert">BLOCK !</div>';
				break;
			case 'report':
				$actions->action_report($id_user_1, $id_user_2);
				echo 	'<div class="alert alert-success" role="alert">REPORT !</div>';
				break;
			case 'dislike':
				$actions->action_dislike($id_user_1, $id_user_2);
				echo 	'<div class="alert alert-success" role="alert">Dislike !</div>';
				break;
			case 'unblock':
				$actions->action_unblock($id_user_1, $id_user_2);
				echo 	'<div class="alert alert-success" role="alert">Unblock !</div>';
				break;
		}



	}
 ?>
