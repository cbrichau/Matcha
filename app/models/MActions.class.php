<?php
/* ************************************************************** *\
	Send Message and fetch messages.
\* ************************************************************** */
class MActions extends MUserMng
{
	//Take id_user_1 , id_user_2 and message
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
		//return 1 if user have already liked or 0 if haven't
	public function user_1_liked_user_2($id_user_1, $id_user_2){
		if($this->is_valid_int_format($id_user_1) && $this->is_valid_int_format($id_user_2)){
			$sql ='SELECT id_user_liked
			FROM users_likes
			WHERE id_user_liker = :id_user_liker AND id_user_liked = :id_user_liked';
			$query = $this->_db->prepare($sql);
			$query->bindValue(':id_user_liker', $id_user_1, PDO::PARAM_INT);
			$query->bindValue(':id_user_liked', $id_user_2, PDO::PARAM_INT);
			$query->execute();
			$res = $query->fetch();
			return(($res) ? 1 : 0);
		}
	}
		//like if he doesn't like yet
	public function action_like($id_user_1, $id_user_2){
		if($this->is_valid_int_format($id_user_1) && $this->is_valid_int_format($id_user_2)){
			if(self::user_1_liked_user_2($id_user_1, $id_user_2) == 0){
				$sql = 'INSERT INTO users_likes
				(id_user_liker, id_user_liked)
				VALUES
				(:id_user_liker, :id_user_liked)';
				$query = $this->_db->prepare($sql);
				$query->bindValue(':id_user_liker', $id_user_1, PDO::PARAM_INT);
				$query->bindValue(':id_user_liked', $id_user_2, PDO::PARAM_INT);
				$query->execute();
			}
		}
	}
		//exact opposite of action_like
	public function action_dislike($id_user_1, $id_user_2){
		if($this->is_valid_int_format($id_user_1) && $this->is_valid_int_format($id_user_2)){
			if(self::user_1_liked_user_2($id_user_1, $id_user_2) == 1){
				$sql = 'DELETE FROM users_likes
				WHERE id_user_liker = :id_user_liker AND id_user_liked = :id_user_liked';
				$query = $this->_db->prepare($sql);
				$query->bindValue(':id_user_liker', $id_user_1, PDO::PARAM_INT);
				$query->bindValue(':id_user_liked', $id_user_2, PDO::PARAM_INT);
				$query->execute();
			}
		}
	}
		//return 1 if user have already liked or 0 if haven't
	public function user_1_blocked_user_2($id_user_1, $id_user_2){
		if($this->is_valid_int_format($id_user_1) && $this->is_valid_int_format($id_user_2)){
			$sql ='SELECT id_user_blocked
			FROM users_blocks
			WHERE id_user_blocker = :id_user_blocker AND id_user_blocked = :id_user_blocked';
			$query = $this->_db->prepare($sql);
			$query->bindValue(':id_user_blocker', $id_user_1, PDO::PARAM_INT);
			$query->bindValue(':id_user_blocked', $id_user_2, PDO::PARAM_INT);
			$query->execute();
			$res = $query->fetch();
			return(($res) ? 1 : 0);
		}
	}

	public function action_block($id_user_1, $id_user_2){
		if($this->is_valid_int_format($id_user_1) && $this->is_valid_int_format($id_user_2)){
			if(self::user_1_blocked_user_2($id_user_1, $id_user_2) == 0){
				$sql = 'INSERT INTO users_blocks
				(id_user_blocker, id_user_blocked)
				VALUES
				(:id_user_blocker, :id_user_blocked)';
				$query = $this->_db->prepare($sql);
				$query->bindValue(':id_user_blocker', $id_user_1, PDO::PARAM_INT);
				$query->bindValue(':id_user_blocked', $id_user_2, PDO::PARAM_INT);
				$query->execute();

			}
		}
	}

	public function action_unblock($id_user_1, $id_user_2){
		if($this->is_valid_int_format($id_user_1) && $this->is_valid_int_format($id_user_2)){
			if(self::user_1_blocked_user_2($id_user_1, $id_user_2) == 1){
				$sql = 'DELETE FROM users_blocks
				WHERE id_user_blocker = :id_user_blocker AND id_user_blocked = :id_user_blocked';
				$query = $this->_db->prepare($sql);
				$query->bindValue(':id_user_blocker', $id_user_1, PDO::PARAM_INT);
				$query->bindValue(':id_user_blocked', $id_user_2, PDO::PARAM_INT);
				$query->execute();
			}
		}
	}

	public function user_1_reported_user_2($id_user_1, $id_user_2){
		if($this->is_valid_int_format($id_user_1) && $this->is_valid_int_format($id_user_2)){
			$sql ='SELECT id_user_reported
			FROM users_reports
			WHERE id_user_reporter = :id_user_reporter AND id_user_reported = :id_user_reported';
			$query = $this->_db->prepare($sql);
			$query->bindValue(':id_user_reporter', $id_user_1, PDO::PARAM_INT);
			$query->bindValue(':id_user_reported', $id_user_2, PDO::PARAM_INT);
			$query->execute();
			$res = $query->fetch();
			return(($res) ? 1 : 0);
		}
	}
	public function action_report($id_user_1, $id_user_2){
		if($this->is_valid_int_format($id_user_1) && $this->is_valid_int_format($id_user_2)){
			if(self::user_1_reported_user_2($id_user_1, $id_user_2) == 0){
				$sql = 'INSERT INTO users_reports
				(id_user_reporter, id_user_reported)
				VALUES
				(:id_user_reporter, :id_user_reported)';
				$query = $this->_db->prepare($sql);
				$query->bindValue(':id_user_reporter', $id_user_1, PDO::PARAM_INT);
				$query->bindValue(':id_user_reported', $id_user_2, PDO::PARAM_INT);
				$query->execute();
			}
		}
	}
		//give the likers of the given id
	public function who_like_me($id_user){
		if($this->is_valid_int_format($id_user)){
			$sql = 'SELECT id_user_liker
			FROM users_likes
			WHERE id_user_liked = :id_user_liked';
			$query = $this->_db->prepare($sql);
			$query->bindValue(':id_user_liked', $id_user, PDO::PARAM_INT);
			$query->execute();
			$res = $query->fetchALL();
			foreach ($res as $key => $value) {
				$res[$key] = $this->select_user_by('id_user',$value['id_user_liker']);
			}
			return($res);
		}
	}

	public function who_visits_me($id_user){
		$sql = 'SELECT users.username, users_visits.last_visit ,users_visits.id_user_visited
		FROM users
		INNER JOIN users_visits
		ON users.id_user=users_visits.id_user_visited
		WHERE users_visits.id_user_visitor=:id_user_visitor';
		$query = $this->_db->prepare($sql);
		$query->bindValue(':id_user_visitor', $id_user, PDO::PARAM_INT);
		$query->execute();
		$res = $query->fetchALL();
		return ($res);
	}

	//send the profile visited and after the user
	public function I_visit_you($id_user_1, $id_user_2){
		$sql = 'INSERT INTO users_visits
		(id_user_visitor,id_user_visited,last_visit)
		VALUES(:id_user_visitor,:id_user_visited, now())
		ON DUPLICATE KEY UPDATE last_visit=now()';
		$query = $this->_db->prepare($sql);
		$query->bindValue(':id_user_visitor', $id_user_1, PDO::PARAM_INT);
		$query->bindValue(':id_user_visited', $id_user_2, PDO::PARAM_INT);
		$query->execute();
	}
}

 ?>
