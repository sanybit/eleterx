<?php
class Eleterx
{
	// Метод возвращает список сообщений
	public static function getMessagesList($login_sender, $login_recipient) {
		$db = Db::getConnection(); //получаем объект класса PDO из класса Db
		$MessagesList = array();
		
		$result = $db->query("SELECT * FROM ((SELECT * FROM eleterx_messages WHERE login_sender = '".$login_sender."' AND login_recipient = '".$login_recipient."' ORDER BY date DESC LIMIT 0,50) UNION (SELECT * FROM eleterx_messages WHERE login_recipient = '".$login_sender."' AND login_sender = '".$login_recipient."' ORDER BY date DESC LIMIT 0,50)) a ORDER BY date");
		
		$result->setFetchMode(PDO::FETCH_ASSOC); //оставит индексы в виде названий
		
		$i = 0;
		while($row = $result->fetch()) {
			foreach($row as $name => $res) {
				$MessagesList[$i][$name] = $res;
			}
			$i++ ;
		}
		return $MessagesList ;
	}
	
	// Метод возвращает одно сообщение по id
	public static function getMessageItemById($id) {
		$db = Db::getConnection(); //получаем объект класса PDO из класса Db
		$result = $db->query('SELECT * FROM eleterx_messages WHERE id='.$id);
		$result->setFetchMode(PDO::FETCH_ASSOC); //оставит индексы в виде названий
		$messageItem = $result->fetch();
		return $messageItem;
	}
	
	// Метод добавления сообщения
	public static function addMessage($login_sender, $login_recipient, $message) {
		$db = Db::getConnection(); //получаем объект класса PDO из класса Db
		// Описываем нужный запрос к базе данных
		$sql = "INSERT INTO eleterx_messages(login_sender, login_recipient, message) VALUES(:login_sender, :login_recipient, :message)";
		// Подготавливаем SQL запрос (зашита от инъекций)
		$query = $db->prepare($sql); 
		// Выполняем запрос к базе
		if ($query->execute(['login_sender' => $login_sender, 'login_recipient' => $login_recipient, 'message' => $message])) {
			$result = $db->query("SELECT LAST_INSERT_ID()");
			$count = $result->fetchColumn(); //получаем из объекта число
			$message_row = Eleterx::getMessageItemById($count);
			return $count.'/'.$message_row['date'];
		}else return 'Ошибка M45';
	}
	
	// Метод проверки наличия пользователя
	public static function checkingUser($login, $password = false, $iden_canvas = false) {
		$login = htmlspecialchars($login);
		$password = htmlspecialchars($password);
		$iden_canvas = htmlspecialchars($iden_canvas);
		$db = Db::getConnection(); //получаем объект класса PDO из класса Db
		// Описываем нужный запрос к базе данных
		$sql = "SELECT * FROM `eleterx_users` WHERE login = :login OR password = :password OR iden_canvas = :iden_canvas";
		// Подготавливаем SQL запрос (зашита от инъекций)
		$query = $db->prepare($sql); 
		// Выполняем запрос к базе
		if ($query->execute(['login' => $login, 'password' => $password, 'iden_canvas' => $iden_canvas])) {
			$query->setFetchMode(PDO::FETCH_ASSOC); //оставит индексы в виде названий
			$user = $query->fetch();
			return $user;
		}else return 'Ошибка M63';
	}
	
	// Метод добавления пользователя в таблицу
	public static function addUser($login, $password, $iden_canvas) {
		$login = htmlspecialchars($login);
		$password = htmlspecialchars($password);
		$iden_canvas = htmlspecialchars($iden_canvas);
		//$date_reg = date("Y-m-d H:i:s");
		$db = Db::getConnection(); //получаем объект класса PDO из класса Db
		// Описываем нужный запрос к базе данных
		$sql = "INSERT INTO eleterx_users(login, password, iden_canvas) VALUES(:login, :password, :iden_canvas)";
		// Подготавливаем SQL запрос (зашита от инъекций)
		$query = $db->prepare($sql); 
		// Выполняем запрос к базе
		if ($query->execute(['login' => $login, 'password' => $password, 'iden_canvas' => $iden_canvas])) {
			return 'Регистрация выполнена';
		}else return 'Ошибка M80';
	}
	
	// Метод удаления пользователя из таблицы
	public static function delUser($login) {
		$login = htmlspecialchars($login);
		$db = Db::getConnection(); //получаем объект класса PDO из класса Db
		// Описываем нужный запрос к базе данных
		$sql = 'DELETE FROM `eleterx_users` WHERE `login` = ?';
		// Подготавливаем SQL запрос (зашита от инъекций)
		$query = $db->prepare($sql);  
		// Выполняем запрос к базе
		if ($query->execute([$login])) {
			$sql = 'DELETE FROM `eleterx_messages` WHERE `login_recipient` = ?';
			$query = $db->prepare($sql);
			if($query->execute([$login])) {
				$sql = 'DELETE FROM `eleterx_messages` WHERE `login_sender` = ?';
				$query = $db->prepare($sql);
				if($query->execute([$login])) return 'Аккаунт удалён';
				else return 'Ошибка удаления чата пользователя';
			}else return 'Ошибка удаления чата пользователя';		
		}else return 'Ошибка удаления пользователя';
	}
	
	// Метод обнавления статуса
	public static function updateStatus($login) {
		$db = Db::getConnection(); //получаем объект класса PDO из класса Db
		if($db->query("UPDATE eleterx_messages SET status = 2 WHERE login_sender = '".$login."'")) {
				return 'Статус обнавлён';
		}else return 'Ошибка обнавления статуса';
	}
	
	// Метод обновления строки чатов
	public static function delChats($login, $chats) {
		$user_chats = Eleterx::checkingUser($login)['chats'];
		$list_chat = str_replace($chats, '', $user_chats);
		$list_chat = str_replace('&&', '&', $list_chat);
		$list_chat = trim($list_chat, '&');
		$db = Db::getConnection(); //получаем объект класса PDO из класса Db
		if($db->query("UPDATE eleterx_users SET chats = '".$list_chat."' WHERE login = '".$login."'")) {
			return 'Чат удалён';
		}else return 'Ошибка обнавления строки чатов';
	}
	
	// Метод обновления пользователя
	public static function updateUser($login, $iden_canvas = false, $date_last_login = false, $date_last_presence = false, $chats = false) {
		$db = Db::getConnection(); //получаем объект класса PDO из класса Db
		if($chats) {
			$chats = htmlspecialchars($chats);
			$row = Eleterx::checkingUser($login);
			if($row['chats']) {
				foreach (explode("&", $row['chats']) as $value) {
					if($value == $chats) return 'Ошибка чат уже добавлен';
				}
				if($db->query("UPDATE eleterx_users SET chats = '".$row['chats'].'&'.$chats."' WHERE login = '".$login."'")) {
					Eleterx::updateUser($chats, false, false, false, $login);
					return 'чат добавлен';
				}else return 'Ошибка добавления чата';
			}else {
				if($db->query("UPDATE eleterx_users SET chats = '".$chats."' WHERE login = '".$login."'")) {
					Eleterx::updateUser($chats, false, false, false, $login);
					return 'чат добавлен';
				}else return 'Ошибка добавления чата';
			}
		}
		if($iden_canvas) {
			$iden_canvas = htmlspecialchars($iden_canvas);
			if($db->query("UPDATE eleterx_users SET iden_canvas = '".$iden_canvas."' WHERE login = '".$login."'")) {
				return 'Устройство обновлено';
			}else return 'Ошибка M90';
		}
		if($date_last_login) {
			if($db->query("UPDATE eleterx_users SET date_last_login = '".date("Y-m-d H:i:s")."' WHERE login = '".$login."'")) {
				return 'Время входа обновлено';
			}else return 'Ошибка M95';
		}
		if($date_last_presence) {
			if($db->query("UPDATE eleterx_users SET date_last_presence = '".date("Y-m-d H:i:s")."' WHERE login = '".$login."'")) {
				return 'Время просмотра обновлено';
			}else return 'Ошибка M100';
		}
		$result = $db->query('SELECT * FROM eleterx_users WHERE login='.$login);
		$result->setFetchMode(PDO::FETCH_ASSOC); //оставит индексы в виде названий
		$timeUser = $result->fetch();
		return $timeUser['date_last_presence'];
	}
	
	// Метод обновления аватарки
	public static function updateUserAvatar($login, $avatar) {
		$db = Db::getConnection(); //получаем объект класса PDO из класса Db
		if($db->query("UPDATE eleterx_users SET avatar = '".$avatar."' WHERE login = '".$login."'")) {
			return 'Аватар установлен';
		}else return 'Ошибка установки аватара';
	}
}
?>