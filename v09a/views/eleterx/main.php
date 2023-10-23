<div class="left">
		<div class="contacts">
			<header>
				<form onsubmit="sendingform('search');return false">
					<input id="search" type="text" name="search" placeholder="Поиск" />
					<input type="submit" name="submit_search" value="" title="искать" />
				</form>
			</header>
			<section id="chat_list">
				<?php 
					if($parameters['chats'] != '') {
						foreach (explode("&", $parameters['chats']) as $value) {
							echo "<div class='chat_ interlocutor chat_".$value."' onClick='chat_active(`chat_".$value."`)'><div class='avatar'></div><p class='login'>".$value."</p></div>";
						}
					}
				?>
			</section>
		</div>
	</div>
	<div class="center">
		<header>
			<div class="name">
				<p class="login login_">---</p>
				<p class="time time_">был в сети:</p>
			</div>
		</header>
		<section id="messages" ></section>
		<footer>
			<div>
				<div id="textarea" class="textarea" contentEditable="true" ></div>
				<button onClick="sendingform('send')"></button>
			</div>
		</footer>
	</div>
	<div class="right_basic">
		<div class="info">
			<h3>Информация</h3>
			<div class="interlocutor">
				<div class="avatar"></div>
				<p class="login login_">---</p>
			</div>
		</div>
		<div class="settings">
			<h3>Шифрование</h3>
			<div class="key" contentEditable="true">Шифрование пока не работает</div>
		</div>
	</div>
	<div class="fixed_elements">
		<div class="down">
			<!--<div class="score" title="есть непрочитанные сообщения" ></div>-->
			<a href="#textarea" title="вниз" ><div class="arrow-8"></div></a>
		</div>
		<div class="right">
			<div class="setting" title="настройки чата">&#8942;</div>
			<div class="hover"></div>
			<div class="info">
				<h3>Информация</h3>
				<div class="interlocutor">
					<div class="avatar"></div>
					<p class="login login_">---</p>
				</div>
			</div>
			<div class="settings">
				<h3>Шифрование</h3>
				<div class="key" contentEditable="true">Шифрование пока не работает</div>
			</div>
		</div>
		<div class="left_menu">
			<div class="menu menus">&#8801;</div>
			<div class="profile">
				<input type="file" id="file_avatar"/>
				<label for="file_avatar" class="avatar"><?php if(!empty($parameters['avatar'])) echo "<img src='".$parameters['avatar']."'/>"; ?></label>
				<p class="login"><script>document.write(localStorage.getItem('eleterx_login'));</script></p>
			</div>
			<ul>
				<li class="chat">
				Чаты
					<div id="chat_submenu" class="chat_submenu">
						<div id="chat_submenu_first" class='interlocutor' onClick="sendingform('del_chat')"><p class='login'>&times; Удалить текущий чат</p></div>
						<?php 
							if($parameters['chats'] != '') {
								foreach (explode("&", $parameters['chats']) as $value) {
									echo "<div class='chat_ interlocutor chat_".$value."' onClick='chat_active(`chat_".$value."`)'><div class='avatar'></div><p class='login'>".$value."</p></div>";
								}
							}
						?>
					</div>
				</li>
				<li class="theme">
				Тема
					<ul class="theme_submenu">
						<li onClick="theme('none')">по умолчанию</li>
						<li onClick="theme('edit')">редактор</li>
						<?php if(!empty($parameters['theme'])) {
							foreach($parameters['theme'] as $filename) {
								echo '<li onClick="theme(`'.strstr(strstr($filename, 'color_'), '.css', true).'`)">'.strstr(strstr($filename, 'color_'), '.css', true)."</li>";
							}
						}?>
					</ul>
				</li>
				<li class="settings_menu">
				Настройки
					<ul class="settings_submenu">
						<li onClick="info()">О приложении</li>
						<li onClick="sendingform('delAccount')">Удалить аккаунт</li>
						<li onClick="sendingform('newDevice')">Сменить устройство</li>
						<li onClick="exitAccount()">Выйти из аккаунта</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</body>
<script src="/js/crypto-js/md5.js"></script>
<script src="/js/eleterx/eleterx.js"></script>
</html>