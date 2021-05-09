<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/init.php';

class Message
{
	// Global User Fields
	private static $fields = ['sender_id', 'receiver_id', 'message', 'datetime'];
	private static $table_name = "messages";

	// User Static Methods
	public static function send($values)
	{
		global $db;
		return $db->insert(self::$table_name, self::$fields, $values);
	}

	public static function delete($id)
	{
		global $db;
		return $db->delete(self::$table_name, "id", $id);
	}

	public static function deleteAll($sender_id, $reciever_id)
	{
		global $db;
		$table_name = self::$table_name;
		$query = "DELETE FROM $table_name WHERE sender_id = ? AND receiver_id = ?";
		return $db->customQuery($query, [$sender_id, $reciever_id]);
	}
	public static function sendMessage()
	{
		Session::start();
		$sender_id = Session::get('id');
		$respond = [];
		$respond['id'] = $sender_id;
		$respond['success'] = false;
		
		if(isset($_POST['send_message']))
		{
			global $db;
			global $hashids;
			global $filter;

			$receiver_id = filter_input(INPUT_POST,'id', FILTER_SANITIZE_STRING);
			$the_message = filter_input(INPUT_POST,'the_message', FILTER_SANITIZE_STRING);

			$receiver_id = $hashids->decode($receiver_id)[0];

			$user_chat_id = Session::get('user_chat_id');

			if($the_message === "" || $receiver_id === "" || $receiver_id == 0)
			{
				echo json_encode($respond);exit;
			}
			if($user_chat_id != $receiver_id )
			{
				echo json_encode($respond);exit;
			}

			$user = Session::get('user');

			$the_message_filtered = $filter->filter($the_message);
			if( $user->usertype == 'user' && $the_message !== $the_message_filtered)
			{
				User::crossBadWords();
				if(User::checkTermination())
				{
					$respond['success'] = false;
					$respond['status'] = 0;

					$db->update('users', ['login'], [0], 'id', $sender_id);
					$db->update('users', ['status'], [0], 'id', $sender_id);

					Session::unset('id');
					Session::unset('username');
					Session::unset('email');
					Session::unset('user');
					
					session_destroy();
					echo json_encode($respond);exit;
				}
			}

			$datetime = new Datetime();
			$now = $datetime->format('Y-m-d H:i');

			$values = [$sender_id, $receiver_id, $the_message_filtered, $now];
			if(self::send($values))
			{
				$respond['success'] = true;
			}
			echo json_encode($respond);exit;
		}	
	}

	public static function mark_as_seen($sender_id, $receiver_id)
	{
		global $db;
		$query = "UPDATE messages SET seen = 1 WHERE sender_id = ? AND receiver_id = ?";
		return $db->customQuery($query, [$sender_id, $receiver_id], "update");
	}
}