<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Загрузка</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="/views/eleterx/login/favicon.ico">
</head>
<style>
	.lds-back {
	  background-color: rgba(0,0,0,0.5);
	  position: fixed;
	  top: 0;
	  left: 0;
	  width: 100%;
	  height: 100%;
	}
	.lds-default {
	  display: inline-block;
	  position: fixed;
	  top: 50%;
	  left: 50%;
	  width: 80px;
	  height: 80px;
	  
	}
	.lds-default div {
	  position: absolute;
	  width: 6px;
	  height: 6px;
	  background: green;
	  border-radius: 50%;
	  animation: lds-default 1.2s linear infinite;
	}
	.lds-default div:nth-child(1) {
	  animation-delay: 0s;
	  top: 37px;
	  left: 66px;
	}
	.lds-default div:nth-child(2) {
	  animation-delay: -0.1s;
	  top: 22px;
	  left: 62px;
	}
	.lds-default div:nth-child(3) {
	  animation-delay: -0.2s;
	  top: 11px;
	  left: 52px;
	}
	.lds-default div:nth-child(4) {
	  animation-delay: -0.3s;
	  top: 7px;
	  left: 37px;
	}
	.lds-default div:nth-child(5) {
	  animation-delay: -0.4s;
	  top: 11px;
	  left: 22px;
	}
	.lds-default div:nth-child(6) {
	  animation-delay: -0.5s;
	  top: 22px;
	  left: 11px;
	}
	.lds-default div:nth-child(7) {
	  animation-delay: -0.6s;
	  top: 37px;
	  left: 7px;
	}
	.lds-default div:nth-child(8) {
	  animation-delay: -0.7s;
	  top: 52px;
	  left: 11px;
	}
	.lds-default div:nth-child(9) {
	  animation-delay: -0.8s;
	  top: 62px;
	  left: 22px;
	}
	.lds-default div:nth-child(10) {
	  animation-delay: -0.9s;
	  top: 66px;
	  left: 37px;
	}
	.lds-default div:nth-child(11) {
	  animation-delay: -1s;
	  top: 62px;
	  left: 52px;
	}
	.lds-default div:nth-child(12) {
	  animation-delay: -1.1s;
	  top: 52px;
	  left: 62px;
	}
	@keyframes lds-default {
	  0%, 20%, 80%, 100% {
		transform: scale(1);
	  }
	  50% {
		transform: scale(1.5);
	  }
	}
</style>
<body>
	<div class="lds-back">
	<div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
	</div>
</body>
<script>
	sendIden();
	function sendIden(){
		let formDataIden = document.createElement('form');
		formDataIden.hidden = true;
		formDataIden.action = 'http://todolist/<?php echo $parameters['url']; ?>';
		formDataIden.method = 'POST';
		formDataIden.innerHTML = "<input name='eleterx_login' value='" + localStorage.getItem('eleterx_login') + "'><input name='eleterx_password' value='" + localStorage.getItem('eleterx_password') + "'><input name='iden_canvas' value='" + localStorage.getItem('iden_canvas') + "'><input name='login_recipient' value='" + 'sanu' + "'><input name='theme_name' value='" + localStorage.getItem('theme_name') + "'>";
		document.body.append(formDataIden); //перед отправкой формы, её нужно вставить в документ
		formDataIden.submit();
	}
</script>
</html>