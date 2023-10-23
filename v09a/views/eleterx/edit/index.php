<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Редактор</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="/views/eleterx/edit/favicon.png">
	<link type="text/css" rel="stylesheet" href="/css/eleterx/reset.css" />
	<link type="text/css" rel="stylesheet" href="/css/eleterx/fonts.css" />
	<link type="text/css" rel="stylesheet" href="/views/eleterx/edit/eleterx.css" />
</head>
<body>
<div class="pattern">
	<div class="left">
		<div class="contacts">
			<header>
				<form name="form_search" action="#" method="get">
					<input id="search" type="text" name="search" placeholder="Поиск" />
					<input type="submit" name="submit_search" value="" title="искать" />
				</form>
			</header>
			<section>
				<div class="interlocutor active">
					<div class="avatar"></div>
					<p class="login">Sany</p>
				</div>
				<div class="interlocutor">
					<div class="avatar"></div>
					<p class="login">Alex</p>
				</div>
				<div class="interlocutor">
					<div class="avatar"></div>
					<p class="login">Bobin robin</p>
				</div>
			</section>
		</div>
	</div>
	<div class="center">
		<header>
			<div class="name">
				<p class="login">Sany</p>
				<p class="time">в сети</p>
			</div>
		</header>
		<section id="messages" >
			<h3>11 декабря</h3>
			<div class="sender">
				<span>
					<p class="message">Привет!</p>
					<p class="time">17:00</p>
				</span>
			</div>
			<div class="recipient">
				<span>
					<p class="message">Здарова!</p>
					<p class="time">17:10 <i class='check'></i><i class='check check2'></i></p>
				</span>
			</div>
		</section>
		<footer>
			<form>
				<div id="textarea" class="textarea" contentEditable="true" ></div>
				<input type="submit" name="submit_send" />
			</form>
		</footer>
	</div>
	<div class="right_basic">
		<div class="info">
			<h3>Информация</h3>
			<div class="interlocutor">
				<div class="avatar"></div>
				<p class="login">Sany</p>
			</div>
		</div>
		<div class="settings">
			<h3>Шифрование</h3>
			<div class="key" contentEditable="true"></div>
		</div>
	</div>
	<div class="fixed_elements">
		<div class="down">
			<div class="score" title="есть непрочитанные сообщения" ></div>
			<a href="#textarea" title="вниз" ><div class="arrow-8"></div></a>
		</div>
		<div class="right">
			<div class="setting" title="настройки чата">&#8942;</div>
			<div class="hover"></div>
			<div class="info">
				<h3>Информация</h3>
				<div class="interlocutor">
					<div class="avatar"></div>
					<p class="login">Sany</p>
				</div>
			</div>
			<div class="settings">
				<h3>Шифрование</h3>
				<div class="key" contentEditable="true"></div>
			</div>
		</div>
		<div class="left_menu">
			<div class="menu menus">&#8801;</div>
			<div class="profile">
				<div class="avatar"></div>
				<p class="login">Sany</p>
			</div>
			<ul>
				<li class="chat">
				Чаты
					<div class="chat_submenu">
						<div class="interlocutor active">
							<div class="avatar"></div>
							<p class="login">Sany</p>
						</div>
						<div class="interlocutor">
							<div class="avatar"></div>
							<p class="login">Alex</p>
						</div>
						<div class="interlocutor">
							<div class="avatar"></div>
							<p class="login">Bobin robin</p>
						</div>
					</div>
				</li>
				<li class="theme">
				Тема
					<ul class="theme_submenu">
						<li>Тема 1</li>
						<li>Тема 2</li>
						<li>Тема 3</li>
					</ul>
				</li>
				<li class="settings_menu">
				Настройки
					<ul class="settings_submenu">
						<li>Смена устройства</li>
						<li>Выход</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="edit">
	<h1>Редактор</h1>
	<div>
		<span class="name_theme" contenteditable=true title="Имя на английском"><?php if(!empty($parameters['theme_name'])){echo $parameters['theme_name'];}else{echo 'theme';} ?></span>
		<span class="button_save" onClick="action('save')">Сохранить</span>
		<span class="help" title="Чтобы применить тему, нужно написать в чат с eleterx заявку на применение." onClick="action('help')">?</span>
	</div>
</div>
<pre>
<style id="edit_box" contenteditable=true><?php if(!empty($parameters['theme'])) {
	echo $parameters['theme'];
}else { 
echo '/*----Цвет фона----*/
.pattern { /*body*/
	/*background: linear-gradient(45deg, #3e4152, #4e5368 30%, #656b86);
	background-attachment: fixed;*/
	
}
/*----Цвет шапки с лева----*/
.left header {
	/*background-color: #3a405a;
	box-shadow: 0px 0px 5px #000;*/
	
}
/*----Цвет поиска----*/
.left header form input[name="search"] {
	/*background-color: #dbdbdb;
	color: #656565;
	font-family: "Noah";*/
	
}
.left header form input[name="search"]:hover {
	/*box-shadow: 0px 0px 5px 0px #aaa;*/
	
}
/*----Цвет активного чата----*/
.left section .active {
	/*background-color: #8e97b8;
	font-family: "Geologica_weit";
	box-shadow: 0px 0px 5px #000;
	color: white;*/
	
}
/*----Цвет фона аватарки с лева----*/
.left section .interlocutor .avatar {
	/*background-color: #ffffff;
	font-family: "Geologica_weit";
	color: white;
	background: url("/icons/eleterx/profile.jpeg") no-repeat;
	background-size: cover;*/
	
}
/*----Цвет шапки в центре----*/
.center header {
	/*background-color: #3a405a;
	font-family: "Geologica_weit";
	color: white;
	box-shadow: 0 0 5px #000;*/
	
}
/*----Цвет фона даты----*/
.center section h3 {
	/*background-color: #bdc2d6;
	background: linear-gradient(45deg, #7e92fa, #9cabfa 30%, #b4bffa);
	box-shadow: 0 0 5px #000;
	font-family: "Geologica_weit";
	color: black;*/
	
}
/*----Цвет приходящего сообщения----*/
.center section .sender span {
	/*background: linear-gradient(45deg, #a3acd9, #b8c2f4 30%, #f4f4f4);
	box-shadow: 2px 2px 5px #555;
	font-family: "Lineyka";
	color: black;*/
	
}
/*----Цвет исходящего сообщения----*/
.center section .recipient span {
	/*background: linear-gradient(45deg, #7e92fa, #9cabfa 30%, #b4bffa);
	box-shadow: 2px 2px 5px #000;
	font-family: "Lineyka";
	color: black;*/
	
}
/*----Цвет фона написать сообщение----*/
.center footer {
	/*background-color: #3a405a;
	font-family: "Geologica_weit";
	box-shadow: 0 0 5px #000;*/
	
}
/*----Цвет поля ввода написать сообщение----*/
.center footer .textarea {
	/*background-color: #c0c0c0;
	color: #000;*/
	
}
.center footer .textarea:focus-visible {
  /*height: 14px;
	border: 2px solid #FFFFFF;
	outline: none;
	box-shadow: inset 0px 0px 8px 0px #888;*/
	
}
/*Цвет стрелки отправить*/
.center footer input[name="submit_send"] {
	/*border-left: 20px solid #c0c0c0;
	background-color: #3a405a;*/
	
}
/*----Цвет фона инфо с права----*/
.right_basic .info {
	/*background-color: #878daa;
	font-family: "Geologica_weit";
	box-shadow: 1px 1px 10px #000;
	color: white;*/
	
}
/*----Цвет фона аватарки с права----*/
.right_basic .info .interlocutor .avatar {
	/*background-color: #ffffff;
	background: url("/icons/eleterx/profile.jpeg") no-repeat;
	background-size: cover;*/
	
}
/*----Цвет фона настроек с права----*/
.right_basic .settings {
	/*background-color: #6f748c;
	font-family: "Geologica_weit";
	box-shadow: 1px 1px 10px #000;
	color: white;*/
	
}
/*----Цвет поля ввода ключа----*/
.right_basic .settings .key {
	/*background-color: #484b5a;
	font-family: "Geologica_weit";
	padding: 5px;*/
	
}
.right_basic .settings .key:focus-visible {
  /*border: 2px solid #FFFFFF;
	outline: none;
	box-shadow: inset 0px 0px 8px 0px #888;*/
	
}
/*----Цвет меню выезжающего с права----*/
.fixed_elements .right .info {
	/*background-color: #878daa;
	box-shadow: 0 0 5px #000;
	font-family: "Geologica_weit";
	color: white;*/
	
}
/*----Цвет фона аватарки с права в выезжающем меню----*/
.fixed_elements .right .info .interlocutor .avatar {
	/*background-color: #ffffff;
	background: url("/icons/eleterx/profile.jpeg") no-repeat;
	background-size: cover;*/
	
}
/*----Цвет меню шифрование выезжающего с права----*/
.fixed_elements .right .settings {
	/*background-color: #6f748c;
	box-shadow: 0 0 5px #000;
	color: white;*/
	
}
/*----Цвет поля ввода шифрование выезжающего с права----*/
.fixed_elements .right .settings .key {
	/*background-color: #484b5a;
	font-family: "Geologica_weit";*/
	
}
.fixed_elements .right .settings .key:focus-visible {
	/*border: 2px solid #FFFFFF;
	outline: none;
	box-shadow: inset 0px 0px 8px 0px #888;*/
	
}
/*----Цвет точки на кнопке вниз----*/
.fixed_elements .down .score {
	/*background-color: rgb(255, 0, 0, 0.6);*/
	
}
/*----Цвет фона кнопки вниз----*/
.fixed_elements .down a {
	/*background-color: rgb(100, 100, 100, 0.8);
	font-family: "Geologica_weit";
	color: #fff;*/
	
}
/*----Цвет фона выезжающего меню с лева----*/
.fixed_elements .left_menu {
	/*background-color: #717791;
	box-shadow: 0 0 5px #000;
	font-family: "Geologica_weit";
	color: white;*/
	
}
/*----Цвет фона выезжающего меню с лева в профиле----*/
.fixed_elements .left_menu .profile {
	/*background-color: #4f5365;
	color: white;*/
	
}
/*----Цвет фона аватарки выезжающего меню с лева в профиле----*/
.fixed_elements .left_menu .profile .avatar {
	/*background-color: #ffffff;
	color: white;
	background: url("/icons/eleterx/profile.jpeg") no-repeat;
	background-size: cover;*/
	
}
/*----Цвет фона подсветки в выезжающем меню с лева----*/
.fixed_elements .left_menu ul li:hover {
	/*background-color: #a8b2d9;
	font-family: "Geologica_weit";
	color: white;*/
	
}
/*----Цвет фона 2 в выезжающем меню с лева----*/
.fixed_elements .left_menu ul .chat .chat_submenu .interlocutor {
	/*background-color: #8388a5;
	color: white;*/
	
}
/*----Цвет фона 2 аватарки выезжающего меню с лева----*/
.fixed_elements .left_menu ul .chat .chat_submenu .interlocutor .avatar {
	/*background-color: #ffffff;
	background: url("/icons/eleterx/profile.jpeg") no-repeat;
	background-size: cover;*/
	
}
/*----Цвет фона 2 подсветки в выезжающем меню с лева активного----*/
.fixed_elements .left_menu ul .chat .chat_submenu .active {
	/*background-color: #979dbd;
	color: black;*/
	
}
/*----Цвет фона 2 подсветки в выезжающем меню с лева----*/
.fixed_elements .left_menu ul .chat .chat_submenu .interlocutor:hover {
	/*background-color: #979dbd;
	color: black;*/
	
}
/*----Цвет фона 3 в выезжающем меню с лева----*/
.fixed_elements .left_menu ul .theme .theme_submenu {
	/*background-color: #8388a5;*/
	
}
/*----Цвет фона 3 подсветки в выезжающем меню с лева----*/
.fixed_elements .left_menu ul .theme .theme_submenu li:hover {
	/*background-color: #979dbd;
	color: black;*/
	
}
/*----Цвет фона 3 в выезжающем меню с лева----*/
.fixed_elements .left_menu ul .settings_menu .settings_submenu {
	/*background-color: #8388a5;*/
	
}
/*----Цвет фона 4 подсветки в выезжающем меню с лева----*/
.fixed_elements .left_menu ul .settings_menu .settings_submenu li:hover {
	/*background-color: #979dbd;
	color: black;*/
	
}
/*плавный скролл*/
.center section {
	overflow-y: auto;
	-webkit-overflow-scrolling:touch;
}
/*Стили применяются только на устройствах с тач*/
@media (pointer:coarse){
	
}';
}
?>
</style>
</pre>
</body>
<script>
	function action(a) {
		if(a == 'help') alert("Имя на английском. Чтобы применить тему, нужно написать в чат с eleterx заявку на применение.");
		if(a == 'save') {
			let formData = new FormData(); //создаём форму
			let xhr = new XMLHttpRequest(); //Создаём запрос на сервер
			formData.set('name_theme', document.querySelector(".name_theme").innerText);
			formData.set('edit_box', document.querySelector("#edit_box").innerText);
			formData.set('eleterx_login', localStorage.getItem('eleterx_login'));
			formData.set('eleterx_password', localStorage.getItem('eleterx_password'));
			formData.set('button', 'save');
			xhr.open("POST", "/eleterx/edit");
			xhr.timeout = 15000; //время ожидания
			xhr.send(formData);
			//Проверяем статус запроса
			xhr.onload = function() {
			  if (xhr.status != 200) { // анализируем HTTP-статус ответа, если статус не 200, то произошла ошибка
				alert(`Ошибка ${xhr.status}: ${xhr.statusText}`); // Например, 404: Not Found
			  } else { // если всё прошло гладко, выводим результат
				alert(xhr.response); // response -- это ответ сервера
			  }
			};
			xhr.ontimeout = function() {
				// время ожидания запроса истекло.
				alert('Сервер не отвечает');
			}; 
		}
	}
	document.querySelector("[name='submit_search']").onclick = function() {this.disabled = true;} //Отключаем отправку форм
	document.querySelector("[name='submit_send']").onclick = function() {this.disabled = true;} //Отключаем отправку форм
</script>
</html>