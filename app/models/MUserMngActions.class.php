<?php
/* ************************************************************** *\
		MUserMngActions is a continuity of MUserMng
		and manages all actions users may take towards each other:
		- Chat: Send/fetch messages
		- Like:
		- Block
		- Report:
		- Visit:
		- Notify: Sends notifications for some actions.
\* ************************************************************** */

class MUserMngActions extends MUserMng
{
	/* ----------- Chat actions ----------- */

	// Adds a chat message to the database and notifies the receiver.
	public function send_message($sender, $receiver, $message)
	{
		if ($this->is_valid_string_format($message) &&
				$this->is_valid_int_format($receiver) &&
				$this->is_valid_int_format($sender))
		{
			$sql = 'INSERT INTO chat (id_user_1, id_user_2, message, message_date)
		          VALUES (:sender, :receiver, :message, now())';
		  $query = $this->_db->prepare($sql);
		  $query->bindValue(':sender', $sender, PDO::PARAM_STR);
		  $query->bindValue(':receiver', $receiver, PDO::PARAM_STR);
		  $query->bindValue(':message', $message, PDO::PARAM_STR);
		  $query->execute();
			$this->notify('message', $id_user_2);
		}
	}

	// Fetches the chat messages of a given user duo.
	public function fetch_messages($id_user_1, $id_user_2)
	{
		if ($this->is_valid_int_format($id_user_1) &&
		    $this->is_valid_int_format($id_user_2))
		{
			$sql = 'SELECT message , id_user_1 , message_date
							FROM chat
							WHERE ((id_user_1 = :id_user_1 AND id_user_2 = :id_user_2) OR
										 (id_user_1 = :id_user_2 AND id_user_2 = :id_user_1))
							ORDER BY message_date ASC';
		  $query = $this->_db->prepare($sql);
			$query->bindValue(':id_user_1', $id_user_1, PDO::PARAM_INT);
		  $query->bindValue(':id_user_2', $id_user_2, PDO::PARAM_INT);
			$query->execute();
			$res = $query->fetchAll();
			return ($res);
		}
	}

	/* ----------- Common block to execute like/block/report actions ----------- */

	// Takes the action as sql and the user ids, then executes it.
	// Returns the $query for potential extra actions, or FALSE if invalid parameters.
	private function execute_action($id_user_1, $id_user_2, $sql)
	{
		if ($this->is_valid_int_format($id_user_1) &&
				$this->is_valid_int_format($id_user_2) &&
				$id_user_1 != $id_user_2)
		{
			$query = $this->_db->prepare($sql);
			$query->bindValue(':id_user_1', $id_user_1, PDO::PARAM_INT);
			$query->bindValue(':id_user_2', $id_user_2, PDO::PARAM_INT);
			$query->execute();
			return $query;
		}
		return FALSE;
	}

	/* ----------- Like actions ----------- */

	// Checks a relationship (returns 1 if user 1 liked user 2, 0 if not).
	public function user_1_liked_user_2($id_user_1, $id_user_2)
	{
		$sql ='SELECT id_user_liked
					 FROM users_likes
					 WHERE id_user_liker = :id_user_1 AND id_user_liked = :id_user_2';
		$query = $this->execute_action($id_user_1, $id_user_2, $sql);
		if ($query && $query->fetch())
			return 1;
		return 0;
	}

	// Adds a relationship (if he didn't already, user 1 likes user 2).
	public function action_like($id_user_1, $id_user_2)
	{
		if ($this->user_1_liked_user_2($id_user_1, $id_user_2) == 0)
		{
			$sql = 'INSERT INTO users_likes (id_user_liker, id_user_liked)
							VALUES (:id_user_1, :id_user_2)';
			$this->execute_action($id_user_1, $id_user_2, $sql);
		}
	}

	// Removes a relationship (if he did, user 1 doesn't like user 2 anymore).
	public function action_dislike($id_user_1, $id_user_2)
	{
		if ($this->user_1_liked_user_2($id_user_1, $id_user_2) == 1)
		{
			$sql = 'DELETE FROM users_likes
							WHERE id_user_liker = :id_user_1 AND id_user_liked = :id_user_2';
			$this->execute_action($id_user_1, $id_user_2, $sql);
		}
	}

	// Gives the likers of the given id.
	public function who_like_me ($id_user)
	{
		if ($this->is_valid_int_format($id_user))
		{
			$sql = 'SELECT id_user_liker
							FROM users_likes
							WHERE id_user_liked = :id_user_liked';
			$query = $this->_db->prepare($sql);
			$query->bindValue(':id_user_liked', $id_user, PDO::PARAM_INT);
			$query->execute();
			$res = $query->fetchAll();
			foreach ($res as $key => $value)
				$res[$key] = $this->select_user_by('id_user',$value['id_user_liker']);
			return($res);
		}
	}

	/* ----------- Block actions ----------- */

	public function user_1_blocked_user_2($id_user_1, $id_user_2)
	{
		$sql = 'SELECT id_user_blocked
					 	FROM users_blocks
						WHERE id_user_blocker = :id_user_1 AND id_user_blocked = :id_user_2';
		$query = $this->execute_action($id_user_1, $id_user_2, $sql);
		if ($query && $query->fetch())
			return 1;
		return 0;
	}

	public function action_block($id_user_1, $id_user_2)
	{
		if ($this->user_1_blocked_user_2($id_user_1, $id_user_2) == 0)
		{
			$sql = 'INSERT INTO users_blocks (id_user_blocker, id_user_blocked)
							VALUES (:id_user_1, :id_user_2)';
			$this->execute_action($id_user_1, $id_user_2, $sql);
		}
	}

	public function action_unblock($id_user_1, $id_user_2)
	{
		if ($this->user_1_blocked_user_2($id_user_1, $id_user_2) == 1)
		{
			$sql = 'DELETE FROM users_blocks
							WHERE id_user_blocker = :id_user_1 AND id_user_blocked = :id_user_2';
			$this->execute_action($id_user_1, $id_user_2, $sql);
		}
	}

	/* ----------- Report actions ----------- */

	public function user_1_reported_user_2($id_user_1, $id_user_2)
	{
		$sql = 'SELECT id_user_reported
						FROM users_reports
						WHERE id_user_reporter = :id_user_1 AND id_user_reported = :id_user_2';
		$query = $this->execute_action($id_user_1, $id_user_2, $sql);
		if ($query && $query->fetch())
			return 1;
		return 0;
	}

	public function action_report($id_user_1, $id_user_2)
	{
		if ($this->user_1_reported_user_2($id_user_1, $id_user_2) == 0)
		{
			$sql = 'INSERT INTO users_reports (id_user_reporter, id_user_reported)
							VALUES (:id_user_1, :id_user_2)';
			$this->execute_action($id_user_1, $id_user_2, $sql);
		}
	}

	/* ----------- Visit actions ----------- */

	public function who_visits_me($id_user)
	{
		$sql = 'SELECT username, last_visit, id_user_visited
						FROM users
						JOIN users_visits ON users.id_user = users_visits.id_user_visited
						WHERE id_user_visitor = :id_user_visitor';
		$query = $this->_db->prepare($sql);
		$query->bindValue(':id_user_visitor', $id_user, PDO::PARAM_INT);
		$query->execute();
		$res = $query->fetchAll();
		return ($res);
	}

	//send the profile visited and after the user
	public function I_visit_you($id_user_1, $id_user_2)
	{
		if ($id_user_1 !== $id_user_2)
		{
			$sql = 'INSERT INTO users_visits (id_user_visitor,id_user_visited,last_visit)
							VALUES (:id_user_1, :id_user_2, now())
							ON DUPLICATE KEY UPDATE last_visit=now()';
			$this->execute_action($id_user_1, $id_user_2, $sql);
			$this->notify('visited', $id_user_2);
		}
	}

	/* ----------- Notify action ----------- */

	public function notify($action, $id_user)
	{
		$username = $_SESSION['username'];
		switch ($action)
		{
			case 'like':
				$message = $username.' liked you.';
				break;
			case 'visited':
				$message = $username.' visited you.';
				break;
			case 'message':
				$message = $username.' messaged you.';
				break;
			case 'matched':
				$message = $username.' matched with you.';
				break;
			case 'un_matched':
				$message = $username.' disliked you.';
				break;
		}
		$sql = 'INSERT INTO notifications (id_user, message)
						VALUES(:id_user, :message)';
		$query = $this->_db->prepare($sql);
		$query->bindValue(':id_user', $id_user, PDO::PARAM_INT);
		$query->bindValue(':message', $message, PDO::PARAM_STR);
		$query->execute();
	}
}

 ?>
