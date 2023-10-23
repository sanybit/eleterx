<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Вход</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Вход" />
	<meta name="keywords" content="Вход" />
	<link type="text/css" rel="stylesheet" href="/css/eleterx/login.css" />
	<link rel="shortcut icon" href="/views/eleterx/login/favicon.ico">
</head>
<body> 
	<div class="login_block">
		<div class="login_logo">
			<a id="logo" href="/eleterx/login">EleterX</a>
		</div>
		<div id="login_box" onKeyPress="if(event.keyCode == 13) login()">
			<table>
				<tr>
					<th>Логин</th>
					<td><input id="login" type="text" onclick="login_active('#fff')" /></td>
				</tr>
				<tr>
					<th>Пароль</th>
					<td><input id="password" type="password" onclick="login_active('#fff')" /></td>
				</tr>
				<tr>
					<th></th>
					<td><input type="checkbox" id="login_check" /><label for="login_check">Регистрация</label></td>
				</tr>
				<tr>
					<th></th>
					<td><input id="button" type="submit" value="Вход" onclick="login()" /></td>
				</tr>
			</table>
		</div>
		<canvas id="iden" width="150" height="150" hidden="true"></canvas>
	</div>
</body>
<script src="/js/crypto-js/md5.js"></script>
<script src="/js/crypto-js/sha256.js"></script>
<script src="/js/eleterx/login.js"></script>
</html>