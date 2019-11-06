<?php
/* ************************************************************** *\

\* ************************************************************** */
class MChat extends M_Manager
{
	//Take id_user_1 and id_user_2 plus message
	public function send_message($sender,$receiver,$message){
		if($this->is_valid_string_format($message) && $this->is_valid_int_format($receiver) && $this->is_valid_int_format($sender)){
			if($sender > $receiver){
				$tmp = $sender;
				$sender = $receiver;
				$receiver = $tmp;
			}
			$sql = 'INSERT INTO chat
		           (id_user_1, id_user_2, message)
		           VALUES
		           (:sender, :receiver, :message)';
		    $query = $this->_db->prepare($sql);
		    $query->bindValue(':sender', $sender, PDO::PARAM_STR);
		    $query->bindValue(':receiver', $receiver, PDO::PARAM_STR);
		    $query->bindValue(':message', $message, PDO::PARAM_STR);
		    $query->execute();
		}
	}
}
 ?>
