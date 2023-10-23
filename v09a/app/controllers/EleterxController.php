<?php
class EleterxController
{
	// Список сообщений (main)
	public function actionIndex($id = false, $param = false) {
		if($param) { //проверяем существование переменной
			Router::ErrorPage404('Лишний параметр');
			die; //прекратить выполнение текущего скрипта
		}
		$parameters = array(
			'url'=>'eleterx' //для проверки авторизации
		);
		if(empty($_POST['eleterx_login']) || empty($_POST['eleterx_password'])) { //Проверка авторизации
			$templates = array('load');
			LoadingPages::view($templates, $parameters, 'eleterx/');
			die; //прекратить выполнение текущего скрипта
		}
		if(is_array($row = Eleterx::checkingUser($_POST['eleterx_login']))) {
			if(!empty($row['password']) && $row['password'] == $_POST['eleterx_password']) { //если авторизация успешна
				Eleterx::updateUser($row['login'], false, false, true); //Обновляем время присутствия
				if(!empty($_POST['send']) && $_POST['send'] == 'send_message') { // Если пришли по нажатию кнопки отправить
					if(!empty($_POST['message']) && !empty($_POST['login_recipient']) && $_POST['message'] != '' && $_POST['login_recipient'] != 'undefined') {
						echo Eleterx::addMessage($_POST['login_recipient'], $row['login'], $_POST['message']);
						die; //прекратить выполнение текущего скрипта
					}else {
						echo 'Ошибка: не достаточно данных';
						die; //прекратить выполнение текущего скрипта
					}
				}
				if(!empty($_POST['load_messages']) && $_POST['load_messages'] == 'load_messages') { // Если пришли по запросу чата
					if(!empty($_POST['Chat'])) {
						if($Chat_user = Eleterx::checkingUser($_POST['Chat'])) {
							$Chat_messages = Eleterx::getMessagesList($row['login'], $_POST['Chat']);
							$arr = array(
								'messages'=>$Chat_messages,
								'user_avatar'=>$Chat_user['avatar'],
								'user_presence'=>$Chat_user['date_last_presence']
							);
							echo 'arr'.json_encode($arr);
							Eleterx::updateStatus($row['login']);
							die; //прекратить выполнение текущего скрипта
						}else {
							echo 'Ошибка: такого пользователя не существует';
							die; //прекратить выполнение текущего скрипта
						}
					}else {
						echo 'Ошибка: не достаточно данных';
						die; //прекратить выполнение текущего скрипта
					}
				}
				if(!empty($_POST['del_chat']) && $_POST['del_chat'] == 'del_chat') { // Если удалить чат
					if(!empty($_POST['Chat']) && $_POST['Chat'] != 'undefined') {
						$chats = htmlspecialchars($_POST['Chat']);
						if(Eleterx::delChats($row['login'], $chats) == 'Чат удалён') {
							echo Eleterx::delChats($chats, $row['login']);
						}
						die; //прекратить выполнение текущего скрипта
					}else {
						echo 'Ошибка чат не выбран';
						die; //прекратить выполнение текущего скрипта
					}
				}
				$parameters['theme'] = glob(ROOT.'/css/eleterx/tema/color_*.css');
				$templates = array(
					'eleterx',
					'main'
				);
				$parameters['messages'] = Eleterx::getMessagesList($row['login'], $_POST['login_recipient']);
				$parameters['chats'] = Eleterx::checkingUser($row['login'])['chats'];
				$parameters['date_last_presence'] = Eleterx::checkingUser($_POST['login_recipient'])['date_last_presence'];
				$parameters['login_recipient'] = $_POST['login_recipient'];
				$parameters['avatar'] = $row['avatar'];
				if(preg_match("/^color.+/" ,$_POST['theme_name'])) {
					$parameters['theme_name'] = "<link type='text/css' rel='stylesheet' href='/css/eleterx/tema/".$_POST['theme_name'].".css' />";
				}else {
					$parameters['theme_name'] = "none";
				}
				LoadingPages::view($templates, $parameters);
				die; //прекратить выполнение текущего скрипта
			}
		}
		header('Location: /eleterx/login');
	}

	//Метод входа пользователя (login)
	public function actionLogin() {
		$parameters = array(
			'url' => 'eleterx/login' //для проверки авторизации
		);
		if(!empty($_POST['button'])) { // Если пришли по нажатию кнопки
			if(!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['iden_canvas'])) {
				if($_POST['button'] == 'login') {
					if($user = Eleterx::checkingUser($_POST['login'])) {
						if($user['login'] == $_POST['login'] && $user['password'] == $_POST['password'] && $user['iden_canvas'] == $_POST['iden_canvas']) {
							Eleterx::updateUser($user['login'], false, true, false); //обновляем время входа
							echo 'Вход выполнен';
							die; //прекратить выполнение текущего скрипта
						}else {
							if($user['iden_canvas'] == 'new') { //Для смены устройства
								Eleterx::updateUser($user['login'], $_POST['iden_canvas']);
								Eleterx::updateUser($user['login'], false, true, false); //обновляем время входа
								echo 'Вход на новом устройстве';
								die; //прекратить выполнение текущего скрипта
							}
							echo 'Данные не верные';
							die; //прекратить выполнение текущего скрипта
						}
					}else {
						echo 'Не верные данные';
						die; //прекратить выполнение текущего скрипта
					}
				}
				if($_POST['button'] == 'registration') {
					$login_ = htmlspecialchars($_POST['login']);
					if(strlen($login_) < 3) {
						echo 'Логин минимум 3 символа';
						die; //прекратить выполнение текущего скрипта
					}
					if($user = Eleterx::checkingUser($_POST['login'], false, $_POST['iden_canvas'])) {
						if($user['login'] == $_POST['login']) {
							echo 'Логин занят';
							die; //прекратить выполнение текущего скрипта
						}
						if($user['iden_canvas'] == $_POST['iden_canvas']) {
							echo 'К устройству уже привязан аккаунт';
							die; //прекратить выполнение текущего скрипта
						}
					}else {
						echo Eleterx::addUser($_POST['login'], $_POST['password'], $_POST['iden_canvas']);
						die; //прекратить выполнение текущего скрипта
					}
				}
			}else {
				echo 'Не достаточно данных';
				die; //прекратить выполнение текущего скрипта
			}
		}
		if(empty($_POST['eleterx_login']) || empty($_POST['eleterx_password'])) { //Проверка авторизации
			$templates = array('load');
			LoadingPages::view($templates, $parameters, 'eleterx/');
			die; //прекратить выполнение текущего скрипта
		}
		if(is_array($row = Eleterx::checkingUser($_POST['eleterx_login']))) {
			if(!empty($row['password']) && $row['password'] == $_POST['eleterx_password']) { //если авторизация успешна
				if(!empty($_POST['search']) && $_POST['search'] == 'search' && !empty($_POST['search_chat'])) { //если пришли по поиску чата
					if(($chat = Eleterx::checkingUser($_POST['search_chat'])) != 'Ошибка M63') {
						if($chat['login'] == $_POST['search_chat']) {
							echo $chat['login'];
							die; //прекратить выполнение текущего скрипта
						}else {
							echo 'Ошибка: такого логина не существует';
							die; //прекратить выполнение текущего скрипта
						}							
					}
					echo 'Ошибка C160';
					die; //прекратить выполнение текущего скрипта
				}
				if(!empty($_POST['addChat']) && $_POST['addChat'] == 'addChat' && !empty($_POST['add_chat'])) { //если пришли по добавлению чата
					echo Eleterx::updateUser($row['login'], false, false, false, $_POST['add_chat']);
					die; //прекратить выполнение текущего скрипта
				}
				if(!empty($_POST['newDevice']) && $_POST['newDevice'] == 'newDevice') {
					if($row['iden_canvas'] == $_POST['iden_canvas']) {
						echo Eleterx::updateUser($row['login'], 'new');
						die; //прекратить выполнение текущего скрипта
					}else {
						echo 'Ошибка C164';
						die; //прекратить выполнение текущего скрипта
					}
				}
				if(!empty($_POST['delAccount']) && $_POST['delAccount'] == 'delAccount') {
					if($row['iden_canvas'] == $_POST['iden_canvas']) {
						echo Eleterx::delUser($row['login']);
						die; //прекратить выполнение текущего скрипта
					}else {
						echo 'Ошибка C173';
						die; //прекратить выполнение текущего скрипта
					}
				}
				if(!empty($_POST['file_avatar']) && $_POST['file_avatar'] == 'file_avatar') { //добавление аватарки
					if(!empty($_POST['file_image'])) {
						echo Eleterx::updateUserAvatar($row['login'], $_POST['file_image']);
						die; //прекратить выполнение текущего скрипта
					}else {
						echo 'Ошибка Файл пустой';
						die; //прекратить выполнение текущего скрипта
					}
				}
				header('Location: /eleterx');
			}
		}
		$templates = array(
			'login'
		);			
		LoadingPages::view($templates, $parameters, 'eleterx/');
	}
	
	//Метод редактора темы (edit)
	public function actionEdit() {
		$parameters = array(
			'url' => 'eleterx/edit' //для проверки авторизации
		);
		if(empty($_POST['eleterx_login']) || empty($_POST['eleterx_password'])) { //Проверка авторизации
			$templates = array('load');
			LoadingPages::view($templates, $parameters, 'eleterx/');
			die; //прекратить выполнение текущего скрипта
		}
		if(is_array($row = Eleterx::checkingUser($_POST['eleterx_login']))) {
			if(!empty($row['password']) && $row['password'] == $_POST['eleterx_password']) { //если авторизация успешна
				$pathfile = false;
				foreach(glob(ROOT.'/css/eleterx/tema/'.$_POST['eleterx_login'].'_*.css') as $filename) {
					$pathfile = $filename;
				}
				if(!empty($_POST['button']) && $_POST['button'] == 'save') {
					if($pathfile) {
						if(!rename($pathfile, ROOT.'/css/eleterx/tema/'.$_POST['eleterx_login'].'_'.$_POST['name_theme'].'.css')) {
							echo 'Не удалось переименовать';
						}
					}
					if($myfile = fopen(ROOT.'/css/eleterx/tema/'.$_POST['eleterx_login'].'_'.$_POST['name_theme'].'.css', "w")) {
						fwrite($myfile, $_POST['edit_box']);
						fclose($myfile);
						echo 'Файл сохранён!';
					}else {
						echo 'Не удалось сохранить';
					}
					die; //прекратить выполнение текущего скрипта
				}
				if($pathfile) {
					if($myfile = fopen($pathfile, "r")) {
						$parameters['theme_name'] = substr(strstr(strstr($pathfile, $_POST['eleterx_login'].'_'), '.', true), strlen($_POST['eleterx_login']) + 1);
						$parameters['theme'] = fread($myfile,filesize($pathfile));
						fclose($myfile);
					}
				}
				$templates = array('edit');			
				LoadingPages::view($templates, $parameters, 'eleterx/');
				die; //прекратить выполнение текущего скрипта
			}
		}
		header('Location: /eleterx/login');
	}
}
?>