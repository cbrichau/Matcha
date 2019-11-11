<?php
/* ************************************************************** *\

\* ************************************************************** */
class MChat extends MUserMng
{
	//Take id_user_1 and id_user_2 plus message
	public function send_message($sender,$receiver,$message){
		if($this->is_valid_string_format($message) && $this->is_valid_int_format($receiver) && $this->is_valid_int_format($sender)){
			$sql = 'INSERT INTO chat
		           (id_user_1, id_user_2, message, message_date)
		           VALUES
		           (:sender, :receiver, :message, now())';
		    $query = $this->_db->prepare($sql);
		    $query->bindValue(':sender', $sender, PDO::PARAM_STR);
		    $query->bindValue(':receiver', $receiver, PDO::PARAM_STR);
		    $query->bindValue(':message', $message, PDO::PARAM_STR);
		    $query->execute();
		}
	}
	public function fetch_messages($id_user_1, $id_user_2){
		if($this->is_valid_int_format($id_user_1) && $this->is_valid_int_format($id_user_2)){
			$sql = 'SELECT message , id_user_1 , message_date
					FROM Chat
					WHERE ((id_user_1 = :id_user_1 AND id_user_2 = :id_user_2) OR
							(id_user_1 = :id_user_2 AND id_user_2 = :id_user_1)) ORDER BY message_date ASC';
		    $query = $this->_db->prepare($sql);
			$query->bindValue(':id_user_1', $id_user_1, PDO::PARAM_INT);
		    $query->bindValue(':id_user_2', $id_user_2, PDO::PARAM_INT);
			$query->execute();
			$res = $query->fetchAll();
			return ($res);
		}
	}
}
 ?>
